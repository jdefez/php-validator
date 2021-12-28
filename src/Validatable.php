<?php

namespace Jdefez\PhpValidator;

interface Validatable
{
    public static function setCandidate(Candidate $candidate): Validatable;

    public function setStrategy(int $strategy): Validatable;

    public function setRules(string ...$rules): Validatable;

    public function validates(): bool;
}
