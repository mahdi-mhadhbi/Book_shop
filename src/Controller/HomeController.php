<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LivreRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(LivreRepository $livreRepository): Response
    {

        $categories = [ 
            'Romance' => $livreRepository->findLatestBooksByCategoryName('Romance'),
            'Mystery' => $livreRepository->findLatestBooksByCategoryName('Mystery'),
            'Science Fiction' => $livreRepository->findLatestBooksByCategoryName('Science Fiction'),
            'Manga' => $livreRepository->findLatestBooksByCategoryName('Manga'),
        ];
        return $this->render('home/index.html.twig', [
            'livres' => $livreRepository->findAll(),
            'latests' => $livreRepository->findLatestBooks(),
            'categories' => $categories,
        ]);
    }

    #[Route('/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }
}
