<?php

namespace App\Repository;

use App\Entity\Category;
use App\Interfaces\RepositoryInterface;
use App\Util\Traits\ChangeStateTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collection|Category[]    findAll()
 * @method Collection|Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineCategoryRepositoryImpl extends ServiceEntityRepository implements RepositoryInterface
{
    use ChangeStateTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

}
