<?php

namespace Application\Front\Controller;

use Application\Front\Security\LoginFormAuthenticator;
use Bundles\CustomerBundle\Command\CustomerRegistrationCommand;
use Bundles\CustomerBundle\Form\CustomerRegistrationForm;
use Domain\Core\CommandBus\CommandBusInterface;
use Domain\Customer\Exception\NonUniqueCustomerEmailException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Twig\Environment;

/**
 * Class CustomerRegistrationController.
 */
class CustomerRegistrationController
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var CommandBusInterface
     */
    private $commandBus;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var GuardAuthenticatorHandler
     */
    private $guardAuthenticatorHandler;
    /**
     * @var LoginFormAuthenticator
     */
    private $loginFormAuthenticator;

    /**
     * CustomerRegistrationController constructor.
     *
     * @param Environment               $twig
     * @param FormFactoryInterface      $formFactory
     * @param RouterInterface           $router
     * @param CommandBusInterface       $commandBus
     * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
     * @param LoginFormAuthenticator    $loginFormAuthenticator
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        CommandBusInterface $commandBus,
        GuardAuthenticatorHandler $guardAuthenticatorHandler,
        LoginFormAuthenticator $loginFormAuthenticator
    ) {
        $this->twig = $twig;
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->guardAuthenticatorHandler = $guardAuthenticatorHandler;
        $this->loginFormAuthenticator = $loginFormAuthenticator;
    }

    public function __invoke(Request $request)
    {
        $command = new CustomerRegistrationCommand();
        $form = $this->formFactory->create(CustomerRegistrationForm::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $customer = $this->commandBus->handle($command);

                return $this->guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                    $customer,
                    $request,
                    $this->loginFormAuthenticator,
                    'main'
                );
            } catch (NonUniqueCustomerEmailException $e) {
                $form->get('email')->addError(new FormError($e->getMessage()));
            } catch (\Exception $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return new Response(
            $this->twig->render('@front/CustomerRegistration/index.html.twig', ['form' => $form->createView()])
        );
    }
}
