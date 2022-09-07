<?php

namespace App\Repository;

use App\Entity\Franchise;
use App\Entity\Structure;
use App\Search\StructureSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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


    public function findAllByFranchiseQueries(Franchise $franchise, StructureSearch $search, $filters = null): Query
    {
        //if ($filters !== null){
        $query = $this->createQueryBuilder('s')
            ->where('s.franchise = :franchise')
            ->setParameter('franchise', $franchise->getId());;

        if ($search->getName()) {
            $query = $query
                ->andWhere('s.name LIKE :nameStructure')
                ->setParameter('nameStructure', '%' . $search->getName() . '%');
        }

        //andWhere permet de cumuler les WHERE
        if ($search->isActive() !== null) {
            $query = $query
                ->andWhere('s.active = :activeStructure')
                ->setParameter('activeStructure', $search->isActive());
        }
        //}
        return $query->getQuery();

    }
}
