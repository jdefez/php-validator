<?php

namespace Jdefez\PhpValidator;

interface Ruleable
{
    public static function isSatisfiedBy(Candidate $Candidate): bool;

    public static function getMessage(Candidate $Candidate): string;
}
