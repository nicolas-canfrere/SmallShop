<?php

namespace Application\Front\Controller;

use Application\Front\Form\ShopUserLoginForm;
use Bundles\CustomerBundle\Model\ShopUser;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->isGranted(ShopUser::ROLE)) {
            return $this->redirectToRoute('front_customer_index');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(ShopUserLoginForm::class, ['_username' => $lastUsername]);

        return $this->render(
            '@front/Security/login.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $error,
            )
        );
    }

    public function logout()
    {
        throw new \Exception('nothing to do here');
    }

    public function googleLogin(ClientRegistry $clientRegistry)
    {
        return $clientRegistry->getClient('google_connect')->redirect();
    }

    /**
     * géré par GoogleConnectAuthenticator.
     */
    public function googleLoginCallback()
    {
    }
}
