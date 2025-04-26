<?php

namespace App\Controller\Security;

use App\Controller\AddFlashTrait;
use App\Controller\BaseController;
use App\Controller\CreateFormTrait;
use App\Controller\RequestTrait;
use App\Dto\RegistrationDTO;
use App\Form\RegistrationFormType;
use App\Messenger\CommandBus\Command\RegisterUser;
use App\Messenger\CommandBus\CommandBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

#[AsController]
#[Route('/register', name: 'app_register')]
class Registration extends BaseController
{
    use RequestTrait;
    use CreateFormTrait;
    use AddFlashTrait;

    public function __construct(
        private CommandBusInterface $commandBus,
        private RequestStack $requestStack,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        protected Environment $twig,
    ) {
        parent::__construct($twig);
    }

    public function __invoke(): Response
    {
        $req = $this->getRequest();
        $form = $this->createForm(RegistrationFormType::class, new RegistrationDTO());
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch(new RegisterUser(
                dto: $form->getData(),
            ));

            return new RedirectResponse($this->router->generate('homepage'));
        }

        return $this->respond('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
