<?php

namespace App\Repository;

use App\Entity\Dette;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Dette>
 */
class DetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dette::class);
    }

    public function paginateDettes(int $page, int $limit,int $clientId, string $type): Paginator
    {
        $sql="";
        if ($type=="soldé") {
            $sql=" and d.montant = d.montantVerser";
        }elseif($type=="non_soldé"){
            $sql=" and d.montant != d.montantVerser";
        }
        $query = $this->createQueryBuilder('d')
            ->where('d.client = :clientId'.$sql)
            ->setParameter('clientId', $clientId)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('d.id', 'ASC')
            ->getQuery();
        return new Paginator($query);
    }
    
    public function getTotalMontant(int $clientId)
    {
        return $this->createQueryBuilder('d')
            ->select('SUM(d.montant) as totalDebt')
            ->where('d.client = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function getTotalMontantVerser(int $clientId)
    {
        return $this->createQueryBuilder('d')
            ->select('SUM(d.montantVerser) as totalDebt')
            ->where('d.client = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return Dette[] Returns an array of Dette objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dette
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
