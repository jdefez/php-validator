<?php

namespace Jdefez\PhpValidator;

class Validator implements Validatable
{
    public const BREAK_ON_FIRST_ERROR = 0;

    public const CHECK_ALL_RULE = 1;

    private array $errors = [];

    private array $rules;

    public function __construct(
        public Candidate $canditate,
        public int $strategy = self::BREAK_ON_FIRST_ERROR
    ) {
    }

    public function setRules(array $rules): Validator
    {
        $this->rules = $rules;

        $this->validate();

        return $this;
    }

    public function __invoke(array $rules): Validator
    {
        return $this->setRules($rules);
    }

    protected function validate(): void
    {
        foreach ($this->rules as $rule) {
            $validated = $rule::isSatisfiedBy($this->canditate);

            if (! $validated) {
                $this->errors[] = $rule::getMessage($this->canditate);

                if ($this->strategy === self::BREAK_ON_FIRST_ERROR) {
                    break;
                }
            }
        }
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
