<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Livre;
use App\Entity\Editeur;
use App\Entity\Auteur;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;


class DashboardController extends AbstractDashboardController
{

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/easyadmin_custom.css');
    }
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(LivreCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/images/1.png" alt="Livre" style="">')
            ->renderContentMaximized() // Active l'affichage en pleine largeur
            ->setFaviconPath('/images/2.jpg'); // Ajoute un favicon
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Livres', 'fa-solid fa-book', Livre::class);

        yield MenuItem::linkToCrud('Categorie', 'fas fa-list', Categories::class);
        yield MenuItem::linkToCrud('Auteur ', ' fa-solid fa-pen', Editeur::class);
        yield MenuItem::linkToCrud('Editeur', 'fa-solid fa-user-pen', Auteur::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fa-solid fa-user-pen', User::class);
    }

}