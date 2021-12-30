<?php

namespace Jdefez\PhpValidator;

interface Validatable
{
    public static function setCandidate(Candidate $candidate): Validatable;

    public function setRules(Ruleable|string ...$rules): Validatable;

    public function validates(): bool;
}
