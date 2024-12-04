<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to access this page.');
        }

        // Fetch user's orders
        $commandes = $em->getRepository(Commande::class)->findBy(['user' => $user]);

        if ($request->isMethod('POST')) {
            // Handle form submission
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Update email if changed
            if ($email && $email !== $user->getEmail()) {
                $user->setEmail($email);
            }

            // Update password if provided
            if ($password) {
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
            }

            // Save changes
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Profile updated successfully.');
        }

        return $this->render('profile/index.html.twig', [
            'commandes' => $commandes,
            'user' => $user,
        ]);
    }


#[Route('/profile/update', name: 'profile_update', methods: ['POST'])]
public function updateProfile(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
{
    $user = $this->getUser();

    $username = $request->request->get('username');
    $email = $request->request->get('email');
    $password = $request->request->get('password');

    // Update user data
    $user->setUsername($username);
    $user->setEmail($email);

    if ($password) {
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
    }

    $em->flush();

    $this->addFlash('success', 'Profile updated successfully.');

    return $this->redirectToRoute('app_profile');
}

}
