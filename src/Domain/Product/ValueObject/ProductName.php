<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/02/19
 * Time: 22:44
 */

namespace Domain\Product\ValueObject;


use Webmozart\Assert\Assert;

final class ProductName
{
    /**
     * @var string
     */
    protected $name;

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

    public function equals(ProductName $productName)
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
