<?php

namespace App\Repository;

use App\Entity\OrderedTestQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderedTestQuestion>
 *
 * @method OrderedTestQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderedTestQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderedTestQuestion[]    findAll()
 * @method OrderedTestQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderedTestQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderedTestQuestion::class);
    }

    public function add(OrderedTestQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderedTestQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OrderedTestQuestion[] Returns an array of OrderedTestQuestion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderedTestQuestion
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
