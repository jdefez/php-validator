<?php

namespace Jdefez\Examples;

use Jdefez\PhpValidator\Candidate;
use Jdefez\PhpValidator\Ruleable;

class ColorRule implements Ruleable
{
    public static function isSatisfiedBy(Candidate $candidate): bool
    {
        return in_array($candidate->color, ['redish', 'pinkish']);
    }

    public static function getMessage(Candidate $Candidate): string
    {
        return sprintf('Color "%s" is neither pinkish or redish', $Candidate->color);
    }
}
