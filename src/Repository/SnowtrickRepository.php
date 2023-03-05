<?php

namespace App\Repository;

use App\Entity\Snowtrick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @extends ServiceEntityRepository<Snowtrick>
 *
 * @method Snowtrick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Snowtrick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Snowtrick[]    findAll()
 * @method Snowtrick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SnowtrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Snowtrick::class);
    }

    public function save(Snowtrick $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Snowtrick $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

     // return limited number of snowtricks
     public function limitedSnowtricks()
     {
        return $this->createQueryBuilder('c')
            ->orderBy('c.creationDate', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(2)
            ->getQuery()
            ->getResult();
     }

//    /**
//     * @return Snowtrick[] Returns an array of Snowtrick objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Snowtrick
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
