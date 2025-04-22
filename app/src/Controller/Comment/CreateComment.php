<?php

declare(strict_types=1);

namespace App\Controller\Comment;

use App\Controller\AddFlashTrait;
use App\Controller\BaseController;
use App\Controller\CreateFormTrait;
use App\Controller\RequestTrait;
use App\Dto\CommentDTO;
use App\Entity\Comment;
use App\Entity\Recipe;
use App\Form\CommentType;
use App\Messenger\CommandBus\Command\CreateEntity;
use App\Messenger\CommandBus\CommandBusInterface;
use App\Messenger\QueryBus\Query\ShowQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

#[AsController]
#[Route('/recipe/{recipeId}/comment/', name: 'recipe_comment')]
class CreateComment extends BaseController
{
    use RequestTrait;
    use CreateFormTrait;
    use AddFlashTrait;

    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
        private RequestStack $requestStack,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        protected Environment $twig,
    ) {
        parent::__construct($twig);
    }

    public function __invoke(string $recipeId): Response
    {
        $req = $this->requestStack->getCurrentRequest();

        $recipe = $this->queryBus->query(
            new ShowQuery($recipeId, Recipe::class, 'r')
        );

        $form = $this->createForm(CommentType::class, new CommentDTO());

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentDto = $form->getData();
            $commentDto->recipeId = $recipe->getId();
            $commentDto->recipe = $recipe;

            $this->commandBus->dispatch(
                new CreateEntity($commentDto, Comment::class)
            );

            $this->addFlash('success', 'Comment added successfully! 🤩');

            return new RedirectResponse(
                $this->router->generate('recipe_show', ['id' => $recipe->getId()])
            );
        }

        return $this->respond('recipe/addComment.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }
}
