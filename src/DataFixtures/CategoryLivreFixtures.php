<?php
// src/DataFixtures/CategoryLivreFixtures.php

namespace App\DataFixtures;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Categories; // Corrected to match the entity name
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryLivreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create 100 Editeur
        $editeurs = [];
        for ($i = 1; $i <= 100; $i++) {
            $editeur = new Editeur();
            $editeur->setNom("Editeur " . $i);
            $manager->persist($editeur);
            $editeurs[] = $editeur; // Store editeur in an array for later use
        }

        // Create 100 Auteur
        $auteurs = [];
        for ($i = 1; $i <= 100; $i++) {
            $auteur = new Auteur();
            $auteur->setNom("Auteur " . $i);
            $auteur->setPrenom("Prenom " . $i);
            $manager->persist($auteur);
            $auteurs[] = $auteur; // Store auteur in an array for later use
        }

        // Create 100 Categories
        $categories = [];
        for ($i = 1; $i <= 100; $i++) {
            $category = new Categories(); // Corrected to match the entity name
            $category->setDesignation("Category " . $i);
            $category->setDescription("Description for category " . $i);
            $manager->persist($category);
            $categories[] = $category; // Store category in an array for later use
        }

        // Create 100 Livre
        for ($i = 1; $i <= 100; $i++) {
            $livre = new Livre();
            $livre->setTitre("Livre " . $i);
            $livre->setNbrpage(rand(100, 500));
            $livre->setDateEdition(new \DateTime());
            $livre->setNbrexemplaire(rand(1, 10));
            $livre->setPrix(rand(10, 50));

            // Randomly assign an Editeur
            $livre->setEditeur($editeurs[array_rand($editeurs)]);
            
            // Randomly assign 1 to 3 Auteurs
            $numAuteurs = rand(1, 3); // Randomly choose how many authors to assign (1-3)
            $randomAuteurs = array_rand($auteurs, $numAuteurs); // Get random author indexes

            foreach ((array)$randomAuteurs as $index) { // Ensure it's an array for single index
                $livre->addAuteur($auteurs[$index]); // Add author to the livre
            }

            // Randomly assign a Category
            $livre->setCategories($categories[array_rand($categories)]); // Assuming Livre has setCategories method

            $manager->persist($livre); // Persist each livre
        }

        $manager->flush(); // Flush all changes to the database
    }
}
