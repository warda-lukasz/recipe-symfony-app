<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\FavouritesDTO;
use App\Entity\Comment;
use App\Entity\Recipe;
use App\Form\CommentType;
use App\Form\ResultsPerPageType;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends BaseController
{
    static string $alias = 'r';
    static string $entity = Recipe::class;
    protected static string $sortField = 'title';

    #[Route('/recipe/list', name: 'recipe_list')]
    public function index(Request $req): Response
    {
        return $this->render('recipe/index.html.twig', [
            'pagination' => $this->paginate($req),
            'resultsForm' => $this->createForm(ResultsPerPageType::class)->createView(),
        ]);
    }

    #[Route('/recipe/favourites', name: 'recipe_favs')]
    public function favourites(#[MapQueryString] FavouritesDTO $dto, Request $req): Response
    {
        $qb = $this->getQueryBuilder()
            ->where('r.id IN (:favs)')
            ->setParameter('favs', $dto->favourites);

        $pagination = $this->paginate($req, $qb);

        if (empty($pagination->getItems())) {
            $this->addFlash('info', 'There is no favourites 😥.');
            return $this->redirectToRoute('recipe_list');
        }

        return $this->render('recipe/favs.html.twig', [
            'pagination' => $pagination,
        ]);
    }

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
