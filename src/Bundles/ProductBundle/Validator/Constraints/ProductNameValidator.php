<?php

namespace Bundles\ProductBundle\Validator\Constraints;

use Bundles\ProductBundle\Validator\Constraints\ProductName as ProductNameConstraint;
use Domain\Product\ValueObject\ProductName;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ProductNameValidator extends ConstraintValidator
{
    /**
     * @param ProductName $value
     * @param Constraint  $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ProductNameConstraint) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\ProductName');
        }

        $forbidden = preg_replace('/[\~\#\}\]{\[|\\@\$\*%§\/\><]+/', '', $value->getName());

        if (strlen($forbidden) < strlen($value->getName())) {
            $this->context->buildViolation($constraint->forbiddenChars)
                ->addViolation();
        }
    }
}
