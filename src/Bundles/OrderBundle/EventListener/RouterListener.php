<?php

namespace Bundles\OrderBundle\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RouterListener
 */
class RouterListener implements EventSubscriberInterface
{
    /**
     * @var SessionInterface
     */
    protected $session;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * RouterListener constructor.
     *
     * @param SessionInterface $session
     * @param RouterInterface $router
     */
    public function __construct(SessionInterface $session, RouterInterface $router)
    {
        $this->session = $session;
        $this->router = $router;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->has('_controller')) {
            return;
        }

        if(!$this->session->has('order')) {
            return;
        }

        $route = 'front_order_checkout.' . $request->getLocale();

        return new RedirectResponse($this->router->generate($route), Response::HTTP_FOUND);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST=>[['onKernelRequest', 36]],
        ];
    }
}
