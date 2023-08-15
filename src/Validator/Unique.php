<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Contrainte pour vérifier l'unicité d'un enregistrement.
 *
 * Pour fonctionner on part du principe que l'objet et l'entité aura une méthode "getId()"
 *
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Unique extends Constraint
{
    public string $message = 'Cette valeur est déjà utilisée';

    /**
     * @var class-string<object>|null
     */
    public ?string $entityClass = null;

    public string $field = '';

    public function __construct(string $field, ?string $entityClass = null, ?string $message = null)
    {
        $this->field = $field;
        $this->entityClass = $entityClass ?? $this->entityClass;
        $this->message = $message ?? $this->message;
    }

    public function getRequiredOptions(): array
    {
        return ['field'];
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
