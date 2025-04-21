<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class CreateComment extends BaseController
{
    public function __construct(
        protected Environment $twig,
        private EntityManagerInterface $em,
        private RouterInterface $router
    ) {
        parent::__construct($twig);
    }
}
