<?php

namespace App\Repository;

use App\Entity\NumerosLoteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NumerosLoteria>
 *
 * @method NumerosLoteria|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumerosLoteria|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumerosLoteria[]    findAll()
 * @method NumerosLoteria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumerosLoteriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NumerosLoteria::class);
    }

//    /**
//     * @return NumerosLoteria[] Returns an array of NumerosLoteria objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NumerosLoteria
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
