<?php

namespace Jdefez\Examples;

use Jdefez\PhpValidator\Ruleable;
use Jdefez\PhpValidator\Candidate;

class StringRule implements Ruleable
{
    public static function isSatisfiedBy(Candidate $Candidate): bool
    {
        return strstr($Candidate->color, 'ish') !== false;
    }

    public static function getMessage(Candidate $Candidate): string
    {
        return sprintf('color: %s does not contain "ish"', $Candidate->color);
    }
}
