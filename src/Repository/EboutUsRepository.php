<?php

namespace App\Repository;

use App\Entity\EboutUs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EboutUs|null find($id, $lockMode = null, $lockVersion = null)
 * @method EboutUs|null findOneBy(array $criteria, array $orderBy = null)
 * @method EboutUs[]    findAll()
 * @method EboutUs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EboutUsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EboutUs::class);
    }

    // /**
    //  * @return EboutUs[] Returns an array of EboutUs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EboutUs
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
