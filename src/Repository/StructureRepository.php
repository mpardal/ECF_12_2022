<?php

namespace App\Repository;

use App\Entity\Franchise;
use App\Entity\Structure;
use App\Search\StructureSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Structure>
 *
 * @method Structure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Structure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Structure[]    findAll()
 * @method Structure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Structure::class);
    }

    public function add(Structure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Structure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByFranchise(Franchise $franchise):QueryBuilder
    {
        return $this->createQueryBuilder('s')
            ->where('s.franchiseId = :franchiseId')
            ->setParameter('franchiseId', $franchise->getId());
    }

    public function findAllQueries(StructureSearch $search): Query
    {
        $query = $this->createQueryBuilder('s');

        if ($search->getName()) {
            $query = $query
                ->andWhere('s.name = :nameStructure')
                ->setParameter('nameStructure', $search->getName());
        }

        //andWhere permet de cumuler les WHERE
        if ($search->getActive()) {
            $query = $query
                ->andWhere('s.active = :activeStructure')
                ->setParameter('activeStructure', $search->getActive());
        }

        return $query->getQuery();
    }

//    /**
//     * @return Structure[] Returns an array of Structure objects
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

//    public function findOneBySomeField($value): ?Structure
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
