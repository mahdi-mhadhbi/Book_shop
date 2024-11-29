<?php

namespace App\Repository;

use App\Entity\Auteur;
use App\Entity\Categories;
use App\Entity\Editeur;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // Rechercher les livres avec un prix inférieur à un certain montant
    public function findLivreByPrixInferieur(float $prix): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.prix < :p')
            ->setParameter('p', $prix)
            ->getQuery()
            ->getResult();
    }
    public function findByFilters(array $categories, array $authors, array $editors): array
    {
        $qb = $this->createQueryBuilder('l');

        if (!empty($categories)) {
            $qb->andWhere('l.categories IN (:categories)')
                ->setParameter('categories', $categories);
        }

        if (!empty($authors)) {
            $qb->join('l.auteurs', 'a')
                ->andWhere('a.id IN (:authors)')
                ->setParameter('authors', $authors);
        }

        if (!empty($editors)) {
            $qb->andWhere('l.editeur IN (:editors)')
                ->setParameter('editors', $editors);
        }

        return $qb->getQuery()->getResult();
    }

    // Rechercher le livre avec le prix maximum
    public function findLivreWithMaxPrix(): array
    {
        $livre = $this->createQueryBuilder('l')
            ->select('l')
            ->orderBy('l.prix', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $livre ? [$livre->toArray()] : [];
    }

    // Rechercher les livres par prix et quantité
    public function findLivreByPrixAndQuantite(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.prix > :prix')
            ->andWhere('l.nbrexemplaire < :quantite')
            ->setParameter('prix', 50)
            ->setParameter('quantite', 5)
            ->orderBy('l.titre', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // Rechercher les livres selon une condition de prix et quantité
    public function findLivreByPrixAndQuantiteCondition(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('(l.prix < :prixLow OR l.prix > :prixHigh)')
            ->andWhere('l.nbrexemplaire > :quantite')
            ->setParameter('prixLow', 50)
            ->setParameter('prixHigh', 70)
            ->setParameter('quantite', 10)
            ->orderBy('l.prix', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Rechercher les livres selon une condition de prix et quantité, avec une limite de 5 résultats
    public function findLivreByPrixAndQuantiteCondition5(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('(l.prix < :prixLow OR l.prix > :prixHigh)')
            ->andWhere('l.nbrexemplaire > :quantite')
            ->setParameter('prixLow', 50)
            ->setParameter('prixHigh', 70)
            ->setParameter('quantite', 10)
            ->orderBy('l.prix', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    // Rechercher les livres dont le titre commence par "La"
    public function findLivreByTitreStartsWithLa(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.titre LIKE :titre')
            ->setParameter('titre', 'La%')
            ->getQuery()
            ->getResult();
    }

    public function findLatestBooks(): array
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.id', 'DESC') // Assuming 'id' increments with new entries. Replace with 'createdAt' if available.
            ->setMaxResults(4)       // Limit to the latest 4 books
            ->getQuery()
            ->getResult();
    }

    public function findLatestBooksByCategoryName(string $categoryName): array
{
    return $this->createQueryBuilder('l')
        ->join('l.categories', 'c')
        ->andWhere('c.designation = :designation')
        ->setParameter('designation', $categoryName)
        ->orderBy('l.id', 'DESC') 
        ->getQuery()
        ->getResult();
}


}
