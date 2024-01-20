<?php

use App\Actions\ForceAllLinksTargetBlank;

it('properly change external links to target="_blank"')
    ->expect(fn () => ForceAllLinksTargetBlank::handle(html()))
    ->toBe(cleanHtml());

function html()
{
    return <<<'HTML'
<p>aVisit <a href="https://livewire-powergrid.com">PowerGrid</a> documentation and read more about <a href="/examples/detail">Detail</a>.</p>
<p>In this page you see <a href="#anchor">Anchor</a>.</p>
HTML;
}

function cleanHtml()
{
    return <<<'HTML'
<p>aVisit <a href="https://livewire-powergrid.com" target="_blank">PowerGrid</a> documentation and read more about <a href="/examples/detail">Detail</a>.</p>
<p>In this page you see <a href="#anchor">Anchor</a>.</p>
HTML;
}
