<?php

namespace Application\Front\Security;


use Application\Front\Form\ShopUserLoginForm;
use Bundles\CustomerBundle\Model\ShopUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Class LoginFormAuthenticator
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ) {

        $this->router          = $router;
        $this->formFactory     = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('front_security_login');
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        /*$isLoginFormSubmission =
            $request->getPathInfo() == $this->getLoginUrl() &&
            $request->isMethod('POST');

        return $isLoginFormSubmission;*/

        $isLoginFormSubmission = $request->attributes->get('_route') === 'front_security_login'
               && $request->isMethod('POST');
        return $isLoginFormSubmission;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(ShopUserLoginForm::class);
        $form->handleRequest($request);
        $datas = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $datas['_username']
        );

        return $form->getData(); // ['_username'=>'...', '_password'=>'...']
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        ##return $userProvider->loadUserByUsername($username);

        return $this->entityManager->getRepository(ShopUser::class)->oneByUsernameOrEmail($username);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        return $this->passwordEncoder->isPasswordValid($user, $password);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return RedirectResponse|Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('front_customer_index', ['_locale'=>$request->getLocale()]));
    }
}
