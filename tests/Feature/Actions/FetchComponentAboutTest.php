<?php

use App\Actions\FetchComponentAbout;
use Illuminate\Support\Facades\File;

it('returns empty string when no markdown is found ')
    ->expect(fn () => FetchComponentAbout::handle('idontexist'))
    ->toBe('');

it('properly fetches a component code')
    ->skipWhenCI()
    ->expect(fn () => FetchComponentAbout::handle('foobar'))
    ->toBe(Html());

beforeEach(function () {
    $this->code = demoMD();
    $this->filepath = resource_path('/markdown/Components/FooBarTable.md');
    File::put($this->filepath, $this->code);
});

afterEach(function () {
    unlink($this->filepath);
});

function demoMD()
{
    return <<<'MD'

This component demonstrates how to use a _Special_ [Feature](https://livewire-powergrid.com/).
<br/><br/>
Cool!
MD;
}

function Html()
{
    return <<<'HTML'
<p>This component demonstrates how to use a <em>Special</em> <a href="https://livewire-powergrid.com/">Feature</a>.
<br><br>
Cool!</p>

HTML;
}
