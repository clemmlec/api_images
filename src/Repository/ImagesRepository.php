<?php

namespace App\Repository;

use App\Entity\Images;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Images>
 *
 * @method Images|null find($id, $lockMode = null, $lockVersion = null)
 * @method Images|null findOneBy(array $criteria, array $orderBy = null)
 * @method Images[]    findAll()
 * @method Images[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Images::class);
    }

    public function add(Images $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Images $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findRandImage(): array
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ;
        return  $query->getQuery()->getResult();
    }

    public function findRandImageWithTag($tag): array
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('a.tag = :val')
            ->setParameter('val', $tag)
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ;
        return  $query->getQuery()->getResult();
    }

    public function findImageWithTagId($tag,$id): array
    {

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.tag = :val')
            ->setParameter('val', $tag)
            ;

        $idMax = count($query->getQuery()->getResult());

        while ($id >= $idMax){
            $id -= $idMax;
        }

        if($id <=0){$id=1;}

        $query = $this->createQueryBuilder('a')
        ->andWhere('a.tag = :val')
        ->setParameter('val', $tag)
        ->setFirstResult($id)
        ->setMaxResults(1)
        ;
        
        
        return  $query->getQuery()->getResult();
    }
//    /**
//     * @return Images[] Returns an array of Images objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Images
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
