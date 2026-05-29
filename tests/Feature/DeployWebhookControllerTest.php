<?php

use Illuminate\Support\Facades\RateLimiter;

beforeAll(function () {
    // Modify env value so routes will be booted with mocked value.
    putenv('DEPLOY_ROUTE=my_deploy_url');
});

beforeEach(function () {
    // Clear the throttle rate limiter state before each test run
    RateLimiter::clear(request()->ip() ?: '127.0.0.1');

    // Set up consistent, known configuration variables for our test runs
    config(['app.deploy.secret' => 'my_token']);
    config(['app.deploy.script_path' => fixture('bin/deploy_succeeded.sh')]);
    $this->scriptPath    = config()->string('app.deploy.script_path');
});

it('has deploy route', function () {
    $deployUrl = config()->string('app.url') . '/' . config()->string('app.deploy.route');
    expect(rtrim(route('deploy'), '/'))->toBe(rtrim($deployUrl, '/'));
});

test('it blocks unauthorized deployment requests with missing token', function () {
    $response = $this->postJson(route('deploy'));

    $response->assertStatus(403)
        ->assertJson([
            'status'  => 'error',
            'message' => 'Unauthorized action.',
        ]);
});

test('it blocks requests with an incorrect deploy token', function () {
    $response = $this->withHeaders([
        'X-Deploy-Token' => 'invalid_wrong_token_payload',
    ])->postJson(route('deploy'));

    $response->assertStatus(403)
        ->assertJson([
            'status'  => 'error',
            'message' => 'Unauthorized action.',
        ]);
});

test('it returns 500 error payload if deploy script fails to run', function () {
    config(['app.deploy.script_path' => fixture('bin/deploy_failed.sh')]);

    $response = $this->withHeaders([
        'X-Deploy-Token' => 'my_token',
    ])->postJson(route('deploy'));

    $response->assertStatus(500)
        ->assertJson([
            'status'  => 'error',
            'message' => 'Deployment script execution failed.',
        ]);
});

test('it executes deploy script and returns output on success', function () {
    $response = $this->withHeaders([
        'X-Deploy-Token' => 'my_token',
    ])->postJson(route('deploy'));

    $response->assertStatus(200)
        ->assertJson([
            'status'  => 'success',
            'message' => 'Deployment executed successfully.',
        ]);
});

test('it triggers rate limiter throttle when accessed multiple times', function () {
    for ($i = 0; $i < 2; $i++) {
        $this->withHeaders(['X-Deploy-Token' => 'my_token'])
            ->postJson(route('deploy'))
            ->assertStatus(200);
    }

    // The 3rd consecutive request must trigger the 429 Too Many Requests barrier
    $this->withHeaders(['X-Deploy-Token' => 'my_token'])
        ->postJson(route('deploy'))
        ->assertStatus(429);
});
