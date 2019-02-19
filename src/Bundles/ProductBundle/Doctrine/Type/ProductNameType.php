<?php

namespace Bundles\ProductBundle\Doctrine\Type;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Domain\Product\ValueObject\ProductName;

/**
 * Class ProductNameType
 * @package Bundles\ProductBundle\Doctrine\Type
 */
class ProductNameType extends Type
{
    const NAME = 'product_name';

    /**
     * @param ProductName $value
     * @param AbstractPlatform $platform
     *
     * @return mixed|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string)$value;
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     *
     * @return ProductName
     * @throws \Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ProductName($value);
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(['length' => 255]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
