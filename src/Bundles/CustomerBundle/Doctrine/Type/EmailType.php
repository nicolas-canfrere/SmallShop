<?php

namespace Bundles\CustomerBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Domain\Customer\ValueObject\Email;

/**
 * Class EmailType.
 */
class EmailType extends Type
{
    const NAME = 'email';

    /**
     * @param Email            $value
     * @param AbstractPlatform $platform
     *
     * @return mixed|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    /**
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @return Email
     *
     * @throws \Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Email($value);
    }

    /**
     * @param array            $fieldDeclaration
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
