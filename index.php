<?php

use Jdefez\Examples\Candidate;
use Jdefez\Examples\ColorRule;
use Jdefez\PhpValidator\Validator;

require 'vendor/autoload.php';

$candidate = new Candidate('green');

// $validator = Validator::setCandidate($candidate)
//  ->setRules($rules);
//
// if (! $validator->validates()) {
//  var_dump($validator->errors());
// }

$validator = (new Validator($candidate, Validator::CHECK_ALL_RULE))
    ->setRules([
        ColorRule::class
    ]);

var_dump($validator->isValid(), $validator->errors());
