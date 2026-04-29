<?php

use Michelf\Markdown;

if (!function_exists('md')) {
    function md(string $text): string
    {
        return Markdown::defaultTransform($text);
    }
}