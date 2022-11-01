<?php

namespace App\Repository;

use App\Entity\Coin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Coins\CoinsFilters;

/**
 * @extends ServiceEntityRepository<Coin>
 *
 * @method Coin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coin[]    findAll()
 * @method Coin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coin::class);
    }

    public function add(Coin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Coin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @param CoinsFilters $filters
    *
    * @return Coin[]
    */
   public function findByFilters(CoinsFilters $filters): array
   {
        $offset = $filters->getOffset();
        $qb = $this->createQueryBuilder('c');
        if($filters->getIsFavorite()) {
            $qb->andWhere('c.isFavorite = :isFavorite')
            ->setParameter('isFavorite', $filters->getIsFavorite());
        }
        return $qb->setMaxResults($filters->getPageSize())
        ->setFirstResult($offset)
        ->getQuery()
        ->getResult();
    }

    /**
     * @param int[] $coins
     * 
     * @return int[]
     */
   public function getByCoingeckoIds(array $coins): array
   {
        $result = $this->createQueryBuilder('c')
            ->select('c.coingeckoId')
            ->where('c.coingeckoId in (:coins)')
            ->setParameter('coins', $coins)
            ->getQuery()
            ->getResult();

            return array_column($result,'coingeckoId');
            
    }
}
