<?php

namespace Bundles\ProductBundle\Command;

use Bundles\ProductBundle\Validator\Constraints as CustomAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Domain\Product\Command\ProductCreateCommandHandler;
use Domain\Product\Command\ProductCreateCommandInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;

class ProductCreateCommand implements ProductCreateCommandInterface
{
    /**
     * @var ProductName
     * @CustomAssert\ProductName()
     */
    protected $name;

    /**
     * @var Money
     */
    protected $price;

    /**
     * @var string
     * @Assert\NotBlank(message="champ requis")
     */
    protected $description;
    /**
     * @var ArrayCollection
     */
    protected $tags;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @return ProductName
     */
    public function getName(): ?ProductName
    {
        return $this->name;
    }

    /**
     * @param ProductName $name
     */
    public function setName(ProductName $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Money
     */
    public function getPrice(): ?Money
    {
        return $this->price;
    }

    /**
     * @param Money $price
     */
    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags(): ArrayCollection
    {
        if(!$this->tags) {
            $this->tags = new ArrayCollection();
        }
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     *
     * @return ProductCreateCommand
     */
    public function setTags(ArrayCollection $tags): ProductCreateCommandInterface
    {
        $this->tags = $tags;

        return $this;
    }



    /**
     * @return string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function handleBy(): string
    {
        return ProductCreateCommandHandler::class;
    }
}
