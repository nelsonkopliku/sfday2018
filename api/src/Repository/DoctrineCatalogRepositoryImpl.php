<?php

namespace App\Repository;

use App\Entity\Catalog;
use App\Interfaces\RepositoryInterface;
use App\Util\Traits\ChangeStateTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Catalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catalog[]    findAll()
 * @method Catalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineCatalogRepositoryImpl extends ServiceEntityRepository implements RepositoryInterface
{
    use ChangeStateTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Catalog::class);
    }

}
