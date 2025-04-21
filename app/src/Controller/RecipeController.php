<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Recipe;
use App\Form\CommentType;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    static string $alias = 'r';
    static string $entity = Recipe::class;
    protected static string $sortField = 'title';

    #[Route('/recipe/comment/{id}', name: 'recipe_comment')]
    public function commentRecipe(Recipe $recipe, Request $req): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setRecipe($recipe);
            $comment->setCreatedAt(new DateTimeImmutable());

            $this->em->persist($comment);
            $this->em->flush();

            $this->addFlash('success', 'Comment added successfully! 🤩');

            return new RedirectResponse($this->generateUrl('recipe_show', ['id' => $recipe->getId()]));
        }

        return $this->render('recipe/addComment.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }
}
