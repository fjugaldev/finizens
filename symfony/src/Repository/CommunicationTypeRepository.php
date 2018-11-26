<?php

namespace App\Repository;

use App\Entity\CommunicationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommunicationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommunicationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommunicationType[]    findAll()
 * @method CommunicationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommunicationTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommunicationType::class);
    }

    // /**
    //  * @return CommunicationType[] Returns an array of CommunicationType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommunicationType
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
