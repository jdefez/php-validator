<?php

namespace Jdefez\Examples;

use Jdefez\PhpValidator\Candidate as BaseCandidate;

class Candidate implements BaseCandidate
{
    public function __construct(public string $color)
    {
    }
}
