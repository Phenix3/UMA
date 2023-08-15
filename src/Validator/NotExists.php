<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NotExists extends Constraint
{
    public string $message = 'A record was found for {{ value }}';
    public string $field = 'id';

    /**
     * @var class-string<object>
     */
    public string $class = \stdClass::class;

    public function __construct(array $groups, string $class, ?string $field, ?string $message)
    {
        $this->groups = $groups;
        $this->field = $field ?? $this->field;
        $this->class = $class;
        $this->message = $message ?? $this->message;
    }

    public function getRequiredOptions(): array
    {
        return ['class', 'field'];
    }
}
