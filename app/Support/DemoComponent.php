<?php

namespace App\Support;

use App\Actions\Component\FetchComponentAbout;
use App\Actions\Component\FetchComponentCode;
use App\Actions\Component\FetchComponentConfig;
use App\Actions\Component\GenerateComponentLink;
use App\Actions\Component\MakeComponentTitle;
use App\Actions\Component\ParseComponentName;
use App\Actions\Component\ParseComponentPath;
use App\Actions\Component\ParseComponentTag;
use App\Exceptions\DemoComponentException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Spatie\ShikiPhp\Shiki;

final class DemoComponent
{
    private readonly string $name;

    private readonly string $path;

    private readonly array $config;

    private function __construct(string $componentName)
    {
        $this->name = ParseComponentName::handle($componentName);

        $this->path = ParseComponentPath::handle($this);

        $this->config = FetchComponentConfig::handle($this);

        if (File::missing($this->path)) {
            DemoComponentException::FileDoesNotExist();
        }
    }

    public static function discover($componentName): self
    {
        return new self(componentName: $componentName);
    }

    public function title(): string
    {
        return MakeComponentTitle::handle($this->name);
    }

    public function about(): string
    {
        return FetchComponentAbout::handle($this);
    }

    public function sourceCode(): string
    {
        return Shiki::highlight(
            code: FetchComponentCode::handle($this),
            language: 'php',
            theme: 'github-dark',
        );;

        return FetchComponentCode::handle($this);
    }

    public function link(): string
    {
        return GenerateComponentLink::handle($this);
    }

    public function render(): string
    {
        $componentTag = data_get($this->config, 'component_tag', '<livewire:' . ParseComponentTag::handle($this) . ' />');

        return Blade::render($componentTag);
    }

    public function packages(): array
    {
        return data_get($this->config, 'packages', []);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function __get($propertyName): string
    {
        if (! property_exists($this, $propertyName)) {
            throw new \Exception('Invalid property name: ' . $propertyName);
        }

        return $this->$propertyName;
    }
}
