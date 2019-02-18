<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 11:56
 */

namespace Domain\Product\Signature;


use Domain\Core\Signature\EntityInterface;
use Money\Money;

interface ProductInterface extends EntityInterface
{
    public function getId(): string;

    public function getName(): string;

    public function getPrice(): Money;

    public function getAlias(): string;

    public function getDescription(): string;
}
