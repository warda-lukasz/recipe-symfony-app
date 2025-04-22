<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\CommentDTO;
use App\Entity\Comment;
use App\Entity\Recipe;
use App\Form\CommentType;
use App\Messenger\CommandBus\Command\CreateEntity;
use App\Messenger\QueryBus\Query\ShowQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/recipe/{recipeId}/comment/', name: 'recipe_comment')]
class CreateComment extends BaseController
{
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
