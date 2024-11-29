<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categories>
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    public function findByEditorIds(array $editorIds)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.livres', 'l')
            ->innerJoin('l.editeur', 'e')
            ->where('e.id IN (:editorIds)')
            ->setParameter('editorIds', $editorIds)
            ->getQuery()
            ->getResult();
    }
public function findWithLivresAndEditeurs(int $id): ?Categories
{
    return $this->createQueryBuilder('c')
        ->leftJoin('c.livres', 'l')
        ->leftJoin('l.editeur', 'e')
        ->addSelect('l', 'e') // Eager load `livres` and `editeurs`
        ->where('c.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getOneOrNullResult();
}

    //    /**
    //     * @return Categories[] Returns an array of Categories objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Categories
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
