<?php

namespace Jdefez\Examples;

use Jdefez\PhpValidator\Candidate;
use Jdefez\PhpValidator\Ruleable;

class ColorRule implements Ruleable
{
    public static function isSatisfiedBy(Candidate $candidate): bool
    {
        return in_array($candidate->color, ['red', 'pink']);
    }

    public static function getMessage(Candidate $Candidate): string
    {
        return sprintf('Color "%s" is neither pink or red', $Candidate->color);
    }
}
