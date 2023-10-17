<?php

namespace App\Repository;

use App\Entity\SearchVehicle;
use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 *
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Vehicle $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Vehicle $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function countVehicles()
    {
        return $this->createQueryBuilder('v')
            ->select('count(v.id)')
            ->join('v.model', 'm')
            ->join('m.brand', 'b')
            ->andWhere('b.status = 1')
            ->andWhere('m.status = 1')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Used to list all vehicles with pagination
     * @param SearchVehicle $searchVehicle
     * @return Query
     */
    public function findAllWithPagination(SearchVehicle $searchVehicle): Query
    {
        $query = $this->createQueryBuilder('v');

        $query->join('v.model', 'm')
            ->join('m.brand', 'b')
            ->andWhere('b.status = 1')
            ->andWhere('m.status = 1');

        if ($searchVehicle->getMinYear()) {
            $query->andWhere('v.yearManufacture >= :min')
                ->setParameter(':min', $searchVehicle->getMinYear());
        }

        if ($searchVehicle->getMaxYear()) {
            $query->andWhere('v.yearManufacture <= :max')
                ->setParameter(':max', $searchVehicle->getMaxYear());
        }
       /* $query->orderBy('v.yearManufacture');*/

        return $query->getQuery();
    }

    public function findVehicle(Vehicle $vehicle)
    {
        return $this->createQueryBuilder('v')
            ->join('v.model', 'm')
            ->join('m.brand', 'b')
            ->andWhere('b.status = 1')
            ->andWhere('m.status = 1')
            ->andWhere('v.id = :vehicle')
            ->setParameter('vehicle', $vehicle->getId())
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Vehicle[] Returns an array of Vehicle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
