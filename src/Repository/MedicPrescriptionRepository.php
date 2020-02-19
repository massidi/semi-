<?php

namespace App\Repository;

use App\Entity\MedicPrescription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MedicPrescription|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedicPrescription|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedicPrescription[]    findAll()
 * @method MedicPrescription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicPrescriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicPrescription::class);
    }

    // /**
    //  * @return MedicPrescription[] Returns an array of MedicPrescription objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MedicPrescription
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
