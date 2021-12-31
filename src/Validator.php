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

    public function setRules(Ruleable|string ...$rules): Validator
    {
        $this->rules = $rules;

        return $this;
    }

    /** @throws Exception */
    protected function validate(): void
    {
        foreach ($this->rules as $rule) {
            $this->isRuleable($rule);

            $this->apply($rule);

            if ($this->shouldBreakOnFirstError()) {
                break;
            }
        }
    }

    /** @throws Exception */
    public function validates(?int $strategy = self::BREAK_ON_FIRST_ERROR): bool
    {
        if ($strategy) {
            $this->strategy = $strategy;
        }

        $this->validate();

        return empty($this->errors);
    }

    protected function shouldBreakOnFirstError()
    {
        return $this->strategy === self::BREAK_ON_FIRST_ERROR
            && !empty($this->errors);
    }

    protected function apply(Ruleable|string $rule)
    {
        $validated = $rule::isSatisfiedBy($this->canditate);

        if (!$validated) {
            $this->errors[] = $rule::getMessage($this->canditate);
        }
    }

    /** @throws Exception */
    protected function isRuleable(Ruleable|string $rule): void
    {
        if (!in_array(Ruleable::class, $this->getImplementations($rule))) {
            throw new Exception(sprintf(
                'Rule %s is invalid. It must implement Realable interface.',
                $rule
            ));
        }
    }

    protected function getImplementations(string|Ruleable $rule): array
    {
        return @class_implements($rule) ?: [];
    }
}
