<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 18:05
 */

namespace Bundles\CartBundle\Service;


use Domain\Cart\Cart;
use Domain\Cart\CartRow;
use Domain\Cart\Signature\CartRowInterface;
use Domain\Product\Signature\ProductInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

    public function unserialize(?array $serialized = [])
    {
        foreach ($serialized as $array) {
            $this->rows[$array['productId']] = CartRow::fromArray($array);
        }
    }

    public function addItem(ProductInterface $product, int $count = 1)
    {
        parent::addItem($product, $count);
        $this->persist();
    }

    public function persist()
    {
        $this->session->set($this->sessionKey, $this->serialize());
    }

    public function serialize()
    {
        return array_map(
            function (CartRowInterface $row) {
                return $row->toArray();
            },
            $this->rows
        );
    }

    public function removeItem(ProductInterface $product, int $count = 1)
    {
        parent::removeItem($product, $count);
        $this->persist();
    }

    public function deleteRow(string $id)
    {
        parent::deleteRow($id);
        $this->persist();
    }

    public function clear()
    {
        parent::clear();
        $this->persist();
    }
}
