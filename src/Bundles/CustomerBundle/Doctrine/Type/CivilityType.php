<?php

namespace Bundles\CustomerBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Domain\Customer\ValueObject\Civility;

class CivilityType extends Type
{
    const NAME = 'civility';

    /**
     * @param Civility         $value
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
     * @return Civility
     *
     * @throws \Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Civility($value);
    }

    /**
     * @param array            $fieldDeclaration
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(['length' => 50]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
