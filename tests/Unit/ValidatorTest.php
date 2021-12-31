<?php

namespace Jdefez\tests\Unit;

use Exception;
use Jdefez\PhpValidator\Candidate;
use Jdefez\PhpValidator\Ruleable;
use Jdefez\PhpValidator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private Validator $validator;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = Validator::setCandidate(new class('green') implements Candidate
        {
            public function __construct(public string $color)
            {
            }
        })->setRules(
            new class implements Ruleable
            {
                public static function isSatisfiedBy(Candidate $Candidate): bool
                {
                    return strstr($Candidate->color, 'ish') !== false;
                }

                public static function getMessage(Candidate $Candidate): string
                {
                    return sprintf('color: %s does not contain "ish"', $Candidate->color);
                }
            },
            new class implements Ruleable
            {
                public static function isSatisfiedBy(Candidate $candidate): bool
                {
                    return in_array($candidate->color, ['redish', 'pinkish']);
                }

                public static function getMessage(Candidate $Candidate): string
                {
                    return sprintf('Color "%s" is neither pinkish or redish', $Candidate->color);
                }
            },
        );
    }

    /** @test */
    public function it_validates_all_rules()
    {
        $this->assertFalse($this->validator->validates(Validator::CHECK_ALL_RULE));
        $this->assertCount(2, $this->validator->errors);
    }

    /** @test */
    public function it_breaks_on_first_validation_error()
    {
        $this->assertFalse($this->validator->validates(Validator::BREAK_ON_FIRST_ERROR));
        $this->assertCount(1, $this->validator->errors);
    }

    /** @test */
    public function it_throws_an_exception_if_a_rule_is_not_a_ruleable_instance()
    {
        $this->expectException(Exception::class);
        $this->validator->setRules('SomeFalsyClassname');
        $this->validator->validates();
    }
}
