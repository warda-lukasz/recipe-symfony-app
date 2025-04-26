<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[AsController]
#[Route('/login', name: 'app_login')]
class Login extends BaseController
{
    public function __invoke(AuthenticationUtils $authUtils): Response
    {
        return $this->respond(
            'security/login.html.twig',
            [
                'last_username' => $authUtils->getLastUsername(),
                'error' => $authUtils->getLastAuthenticationError()
            ]
        );
    }
}
