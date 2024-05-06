<?php

namespace App\Actions;

use Illuminate\Support\Collection;

final class ParseAnnotation
{
    public static function handle(string $class): Collection
    {
        $rc  = new \ReflectionClass($class);
        $doc = $rc->getDocComment();

        $pattern = "/@([a-z]+[a-z0–9_]*)(.*)\s{1,}/i";

        //perform the regular expression on the string provided
        preg_match_all($pattern, strval($doc), $matches, PREG_PATTERN_ORDER);

        $annotations = collect();

        foreach ($matches[1] as $key => $value) {
            $annotations->put($value, ltrim(rtrim($matches[2][$key])));
        }

        if ($annotations->has(['route', 'title', 'description']) === false) {
            throw new \Exception(sprintf('Missing annotations in [%s].', $class));
        }

        return $annotations;
    }
}
