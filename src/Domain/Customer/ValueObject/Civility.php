<?php

namespace Domain\Customer\ValueObject;

use Domain\Core\Signature\EqualInterface;
use Webmozart\Assert\Assert;

/**
 * Class Civility
 */
final class Civility implements EqualInterface
{
    /**
     *
     */
    const DEFAULT = 'unknown';

    /**
     * @var string
     */
    private $civility;

    /**
     * Civility constructor.
     *
     * @param string|null $civility
     */
    public function __construct(?string $civility = '')
    {
        Assert::stringNotEmpty($civility, 'Civility can not be empty');
        $this->civility = $civility;
    }

    /**
     * @return string
     */
    public function getCivility(): string
    {
        return $this->civility;
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->civility;
    }


    /**
     * @param Civility $object
     *
     * @return bool
     */
    public function equals($object): bool
    {
        return $this->civility === $object->getCivility();
    }
}
