<?php

namespace App\Repository;

use App\Entity\CoinArchive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoinArchive>
 *
 * @method CoinArchive|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoinArchive|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoinArchive[]    findAll()
 * @method CoinArchive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoinArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoinArchive::class);
    }

    public function save(CoinArchive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CoinArchive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
