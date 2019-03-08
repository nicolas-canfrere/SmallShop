<?php

namespace Bundles\OrderBundle\Service;


use Bundles\OrderBundle\Middlewares\Exception\CartNotValidException;
use Bundles\OrderBundle\Middlewares\Exception\CustomerNotLoggedInException;
use Bundles\OrderBundle\Middlewares\Exception\NoDeliveryAddressException;
use Domain\Order\Order;
use Domain\Order\Signature\OrderFlowInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class OrderManager
 */
class OrderManager
{
    /**
     * @var OrderFlowInterface
     */
    protected $orderFlow;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * OrderManager constructor.
     *
     * @param OrderFlowInterface $orderFlow
     * @param SessionInterface $session
     * @param RouterInterface $router
     */
    public function __construct(
        OrderFlowInterface $orderFlow,
        SessionInterface $session,
        RouterInterface $router
    )
    {
        $this->orderFlow = $orderFlow;
        $this->router = $router;
        $this->session = $session;
    }

    public function __invoke(): Response
    {
        $order = Order::create('abc');

        $this->session->set('order', 'test');
        try {
            $order = $this->orderFlow->handle($order);
            return $this->redirectToRoute('front_home');
        } catch (CartNotValidException $e) {
            return $this->redirectToRoute('front_home');
        } catch (CustomerNotLoggedInException $e) {
            return $this->redirectToRoute('front_security_login');
        } catch (NoDeliveryAddressException $e) {
            return $this->redirectToRoute('front_customer_add_address');
        } catch (\Exception $e) {
            die('message ' . $e->getMessage());
        }
    }

    private function redirectToRoute(string $route, array $parameters = [], int $status = Response::HTTP_FOUND): RedirectResponse
    {
        $url = $this->router->generate($route, $parameters);
        return new RedirectResponse($url, $status);
    }


}
