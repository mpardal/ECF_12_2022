<?php

namespace App\Repository;

use App\Entity\Franchise;
use App\Search\FranchiseSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Franchise>
 *
 * @method Franchise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Franchise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Franchise[]    findAll()
 * @method Franchise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Franchise::class);
    }

    public function add(Franchise $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Franchise $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllQueries(FranchiseSearch $search, $filters = null): Query
    {

        $query = $this->createQueryBuilder('f');
        //if ($search !== null) {
            if ($search->getName()) {
                $query = $query
                    ->andWhere('f.name LIKE :nameFranchise')
                    ->setParameter('nameFranchise', '%' . $search->getName() . '%');
            }

            //andWhere permet de cumuler les WHERE
            if ($search->isActive() !== null) {
                $query = $query
                    ->andWhere('f.active = :activeFranchise')
                    ->setParameter('activeFranchise', $search->isActive());
            }

            if ($search->getCity()) {
                $query = $query
                    ->andWhere('f.city LIKE :cityFranchise')
                    ->setParameter('cityFranchise', '%' . $search->getCity() . '%');
            }
        //}
        return $query->getQuery();
    }

  /*  public function findQuery(Franchise $franchise):Query
    {
        $query = $this->findQueries();

        if ($franchise->getName()){
            $query = $query
                ->andWhere('f.name')

        }
    }*/


//    /**
//     * @return Franchise[] Returns an array of Franchise objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Franchise
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
