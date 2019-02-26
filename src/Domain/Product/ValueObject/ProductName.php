<?php

namespace Domain\Product\ValueObject;

use Domain\Core\Signature\EqualInterface;
use Webmozart\Assert\Assert;

final class ProductName implements EqualInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * ProductName constructor.
     *
     * @param string $name
     *
     * @throws \Exception
     */
    public function __construct($name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    public function validate(string $name)
    {
        Assert::stringNotEmpty($name, 'Name can not be empty');
        Assert::minLength($name, 2, 'Name must have at least 2 chars');
        Assert::maxLength($name, 255, 'Name must have 255 chars maximum');
    }

    /**
     * @param ProductName $productName
     *
     * @return bool
     */
    public function equals($productName): bool
    {
        return $this->name === $productName->getName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
