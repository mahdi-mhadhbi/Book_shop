<?php
namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Editeur;
use App\Entity\Livre;
use App\Form\BookFilterType;
use App\Form\CategoriesType;
use App\Repository\AuteurRepository;
use App\Repository\CategoriesRepository;
use App\Repository\EditeurRepository;  // Import the EditeurRepository
use App\Repository\LivreRepository;
use ContainerSETaAh8\getLivreRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
final class CategoriesController extends AbstractController
{








    /*#[Route('/new', name: 'app_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, EditeurRepository $editeurRepository): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);

        // Get all editors and pass them to the form
        $editors = $editeurRepository->findAll();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
            'editors' => $editors, // Passing editors to the view
        ]);
    }

    #[Route('/{id}', name: 'app_categories_show', methods: ['GET'])]
    public function show(Categories $category, CategoriesRepository $categoriesRepository, EditeurRepository $editeurRepository): Response
    {
        // Fetch all editors to display in the view
        $editors = $editeurRepository->findAll();
        return $this->render('categories/show.html.twig', [
            'category' => $category,
            'editors' => $editors, // Passing editors to the view
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categories $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categories_delete', methods: ['POST'])]
    public function delete(Request $request, Categories $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }*/

    #[Route('/{params}', name: 'app_categories_index', requirements: ['params' => '.*'])]
    public function index(LivreRepository $livreRepository, Request $request, string $params = ''): Response
    {
        // Split the parameters, ignoring empty segments
        $segments = array_filter(explode('/', $params));

        // Assign parameters based on position
        $cat = $segments[0] ?? null;
        $ed = $segments[1] ?? null;
        $aut = $segments[2] ?? null;

        // Convert to arrays or handle nulls as needed
        $categories = $cat ? explode(',', $cat) : [];
        $editors = $ed ? explode(',', $ed) : [];
        $authors = $aut ? explode(',', $aut) : [];

        // Retrieve books based on filters
        $books = $livreRepository->findByFilters($categories, $authors, $editors);

        // Build and handle the filter form
        $form = $this->createForm(BookFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $c = array_map(fn($cat) => $cat->getId(), $form->get('categories')->getData()->toArray());
            $a = array_map(fn($author) => $author->getId(), $form->get('authors')->getData()->toArray());
            $e = array_map(fn($editor) => $editor->getId(), $form->get('editors')->getData()->toArray());

            return $this->redirectToRoute('app_categories_index', [
                'params' => implode('/', [
                    implode(',', $c) ?: '',
                    implode(',', $e) ?: '',
                    implode(',', $a) ?: '',
                ]),
            ]);
        }

        return $this->render('categories/index.html.twig', [
            'books' => $books,
            'filterForm' => $form->createView(),
        ]);
    }




}
