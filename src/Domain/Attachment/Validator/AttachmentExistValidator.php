<?php

namespace App\Domain\Attachment\Validator;

use App\Domain\Attachment\Entity\Attachment;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AttachmentExistValidator extends ConstraintValidator
{
    /**
     * @param Attachment      $value
     * @param AttachmentExist $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof NonExistingAttachment) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->setParameter('{{ id }}', (string) $value->getId())
            ->addViolation();
    }
}
