<?php

namespace App\Repository;

use App\Entity\HomeGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HomeGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeGroup[]    findAll()
 * @method HomeGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HomeGroup::class);
    }

//    /**
//     * @return HomeGroup[] Returns an array of HomeGroup objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HomeGroup
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
