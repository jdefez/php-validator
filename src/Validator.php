<?php

namespace Jdefez\PhpValidator;

use Exception;

class Validator implements Validatable
{
    public const BREAK_ON_FIRST_ERROR = 0;
    public const CHECK_ALL_RULE = 1;

    public int $strategy = 0;

    public array $errors = [];

    private array $rules;

    final public function __construct(public Candidate $canditate)
    {
    }

    public static function setCandidate(Candidate $candidate): Validator
    {
        return new static($candidate);
    }

    public function setRules(string ...$rules): Validator
    {
        $this->rules = $rules;

        return $this;
    }

    public function setStrategy(int $strategy): Validator
    {
        $this->strategy = $strategy;

        return $this;
    }

    protected function validate(): void
    {
        foreach ($this->rules as $rule) {
            $this->apply($rule);

            if ($this->shouldBreakOnFirstError()) {
                break;
            }
        }
    }

    public function validates(): bool
    {
        $this->validate();

        return empty($this->errors);
    }

    protected function shouldBreakOnFirstError()
    {
        return $this->strategy === self::BREAK_ON_FIRST_ERROR
            && !empty($this->errors);
    }

    /** @throws Exception */
    protected function apply(string $rule)
    {
        $this->isRuleable($rule);

        $validated = $rule::isSatisfiedBy($this->canditate);

        if (!$validated) {
            $this->errors[] = $rule::getMessage($this->canditate);
        }
    }

    /** @throws Exception */
    protected function isRuleable(string $rule): void
    {
        $implementations = @class_implements($rule) ?: [];

        if (!in_array(Ruleable::class, $implementations)) {
            throw new Exception(sprintf('Invalid Rule given: %s', $rule));
        }
    }
}
