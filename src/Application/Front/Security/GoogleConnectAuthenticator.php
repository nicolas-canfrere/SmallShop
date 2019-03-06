<?php

namespace Application\Front\Security;

use Bundles\CustomerBundle\Command\CustomerOauthRegistrationCommand;
use Bundles\CustomerBundle\Model\ShopUser;
use Domain\Core\CommandBus\CommandBusInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;
use Domain\Customer\ValueObject\Email;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GoogleConnectAuthenticator extends SocialAuthenticator
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var ClientRegistry
     */
    protected $clientRegistry;

    /**
     * @var CommandBusInterface
     */
    protected $commandBus;

    /**
     * GoogleConnectAuthenticator constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param RouterInterface             $router
     * @param ClientRegistry              $clientRegistry
     * @param CommandBusInterface         $commandBus
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        RouterInterface $router,
        ClientRegistry $clientRegistry,
        CommandBusInterface $commandBus
    ) {
        $this->customerRepository = $customerRepository;
        $this->router = $router;
        $this->clientRegistry = $clientRegistry;
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request                      $request
     * @param AuthenticationException|null $authException
     *
     * @return Response|void
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return 'front_security_google_connect_callback' === $request->attributes->get('_route');
    }

    /**
     * @param Request $request
     *
     * @return \League\OAuth2\Client\Token\AccessToken|mixed
     */
    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getGoogle());
    }

    /**
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return ShopUser|UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $googleUser */
        $googleUser = $this->getGoogle()->fetchUserFromToken($credentials);

        $email = $googleUser->getEmail();
        /** @var ShopUser $customerExists */
        $customerExists = $this->customerRepository->oneByEmail($email);

        if ($customerExists) {
            return $customerExists;
        }


        $command = new CustomerOauthRegistrationCommand(
            new Email($googleUser->getEmail()),
            'google',
            $googleUser->getLastName(),
            $googleUser->getFirstName()
        );

        $customer = $this->commandBus->handle($command);

        return $customer;
    }

    /**
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return RedirectResponse|Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new RedirectResponse($this->router->generate('front_security_login'));
    }

    /**
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey
     *
     * @return RedirectResponse|Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('front_home'));
    }

    /**
     * @return \KnpU\OAuth2ClientBundle\Client\OAuth2Client
     */
    private function getGoogle()
    {
        return $this->clientRegistry->getClient('google_connect');
    }
}
