<?php

namespace Bundles\CartBundle\Service;

use Domain\Cart\Cart;
use Domain\Cart\CartRow;
use Domain\Cart\Signature\CartRowInterface;
use Domain\Product\Signature\ProductInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SessionCart.
 */
class SessionCart extends Cart
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var string|null
     */
    private $sessionKey = '__cart__';

    /**
     * SessionCart constructor.
     *
     * @param SessionInterface $session
     * @param string           $defaultCurrency
     * @param string|null      $sessioKey
     */
    public function __construct(SessionInterface $session, string $defaultCurrency = 'EUR', ?string $sessioKey = '')
    {
        parent::__construct($defaultCurrency);
        $this->session = $session;
        if ($sessioKey) {
            $this->sessionKey = $sessioKey;
        }
        $sessionCart = $this->session->get($this->sessionKey, []);
        $this->unserialize($sessionCart);
    }

    /**
     * @param array|null $serialized
     */
    public function unserialize(?array $serialized = []): void
    {
        foreach ($serialized as $array) {
            $this->rows[$array['productId']] = CartRow::fromArray($array);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(ProductInterface $product, int $count = 1): void
    {
        parent::addItem($product, $count);
        $this->persist();
    }


    public function persist(): void
    {
        $this->session->set($this->sessionKey, $this->serialize());
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return array_map(
            function (CartRowInterface $row) {
                return $row->toArray();
            },
            $this->rows
        );
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem(ProductInterface $product, int $count = 1): void
    {
        parent::removeItem($product, $count);
        $this->persist();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRow(string $id): void
    {
        parent::deleteRow($id);
        $this->persist();
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): void
    {
        parent::clear();
        $this->persist();
    }
}
