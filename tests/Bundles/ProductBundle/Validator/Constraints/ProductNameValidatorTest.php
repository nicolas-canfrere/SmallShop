<?php

namespace Tests\Bundles\ProductBundle\Validator\Constraints;

use Bundles\ProductBundle\Validator\Constraints\ProductName as ProductNameConstraint;
use Bundles\ProductBundle\Validator\Constraints\ProductNameValidator;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;
use Tests\Domain\Product\ProductTestCase;

class ProductNameValidatorTest extends ProductTestCase
{
    /**
     * @test
     */
    public function forbiddenCharsValidation()
    {
        $product = $this->createProduct('abc', '~#}]{[|\@$*%§/><', 100);

        $constraint = new ProductNameConstraint();
        $validator  = $this->initValidator($constraint->forbiddenChars);

        $validator->validate($product, $constraint);
    }

    /**
     * @test
     */
    public function noSpecialCharsMustPass()
    {
        $product = $this->createProduct('abc', 'pretty name', 100);

        $constraint = new ProductNameConstraint();
        $validator = $this->initValidator();

        $validator->validate($product, $constraint);
    }

    protected function initValidator($expectedMessage = null)
    {
        $builder = $this->getMockBuilder(ConstraintViolationBuilder::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['addViolation'])
                        ->getMock();

        $context = $this->getMockBuilder(ExecutionContext::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['buildViolation'])
                        ->getMock();

        if ($expectedMessage) {
            $builder->expects($this->once())->method('addViolation');

            $context->expects($this->once())
                    ->method('buildViolation')
                    ->with($this->equalTo($expectedMessage))
                    ->will($this->returnValue($builder));
        } else {
            $context->expects($this->never())->method('buildViolation');
        }

        $validator = $this->getValidatorInstance();
        /* @var ExecutionContext $context */
        $validator->initialize($context);

        return $validator;
    }

    protected function getValidatorInstance()
    {
        return new ProductNameValidator();
    }
}
