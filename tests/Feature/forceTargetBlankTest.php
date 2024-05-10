<?php

it('properly change external links to target="_blank"', function () {
    $this->html = str($this->html)->forceTargetBlank()->toString();
    expect($this->html)->toBe($this->cleanHtml);
});

beforeEach(function () {
    $this->html = <<<'HTML'
<p>aVisit <a href="https://livewire-powergrid.com">PowerGrid</a> documentation and read more about <a href="/examples/detail">Detail</a>.</p>
<p>In this page you see <a href="#anchor">Anchor</a>.</p>
HTML;

    $this->cleanHtml = <<<'HTML'
<p>aVisit <a href="https://livewire-powergrid.com" target="_blank">PowerGrid</a> documentation and read more about <a href="/examples/detail">Detail</a>.</p>
<p>In this page you see <a href="#anchor">Anchor</a>.</p>
HTML;
});
