<?php

namespace Jdefez\PhpValidator;

interface Validatable
{
    public function setRules(array $rules): Validatable;

    public function isValid(): bool;

    public function errors(): array;
}
