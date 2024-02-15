<?php

namespace App\Support;

use App\Actions\FetchComponentAbout;
use App\Actions\FetchComponentCode;
use App\Actions\GenerateComponentLink;
use App\Actions\MakeComponentTitle;
use App\Actions\ParseComponentName;

final class ExampleComponent
{
    private function __construct(
        private readonly string $name,
        private readonly string $title,
        private readonly string $about,
        private readonly string $source_code,
        private readonly string $github_url
    ) {
    }

    public static function discover($componentName): self
    {
        return new self(
            name: ParseComponentName::handle($componentName),
            title: MakeComponentTitle::handle($componentName),
            about: FetchComponentAbout::handle($componentName),
            source_code: FetchComponentCode::handle($componentName),
            github_url: GenerateComponentLink::handle($componentName),
        );
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function __get($propertyName): string
    {
        if (! property_exists($this, $propertyName)) {
            throw new \Exception('Invalid property name: '.$propertyName);
        }

        return $this->$propertyName;
    }
}
