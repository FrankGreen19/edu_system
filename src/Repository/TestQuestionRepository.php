<?php

namespace App\Repository;

use App\Entity\TestQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestQuestion>
 *
 * @method TestQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestQuestion[]    findAll()
 * @method TestQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestQuestion::class);
    }

    public function add(TestQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TestQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
