<?php

namespace App\Repository;

use App\Entity\CryptoMonnaie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CryptoMonnaie>
 *
 * @method CryptoMonnaie|null find($id, $lockMode = null, $lockVersion = null)
 * @method CryptoMonnaie|null findOneBy(array $criteria, array $orderBy = null)
 * @method CryptoMonnaie[]    findAll()
 * @method CryptoMonnaie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptoMonnaieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoMonnaie::class);
    }

//    /**
//     * @return CryptoMonnaie[] Returns an array of CryptoMonnaie objects
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

//    public function findOneBySomeField($value): ?CryptoMonnaie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
