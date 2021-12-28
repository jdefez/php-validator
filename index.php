<?php

use Jdefez\Examples\Candidate;
use Jdefez\Examples\ColorRule;
use Jdefez\Examples\StringRule;
use Jdefez\PhpValidator\Validator;

require 'vendor/autoload.php';

$validator = Validator::setCandidate(new Candidate('greenish'))
    ->setStrategy(Validator::CHECK_ALL_RULE)
    ->setRules(
        StringRule::class,
        ColorRule::class,
    );

if (!$validator->validates()) {
    var_dump($validator->errors);
}
