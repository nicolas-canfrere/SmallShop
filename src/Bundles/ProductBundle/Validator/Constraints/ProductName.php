<?php

namespace Bundles\ProductBundle\Validator\Constraints;

use Doctrine\Common\Annotations\Annotation\Target;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class ProductName extends Constraint
{
    public $forbiddenChars = 'Product name contains forbidden chars';
}
