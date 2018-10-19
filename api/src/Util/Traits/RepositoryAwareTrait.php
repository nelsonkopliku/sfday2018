<?php

declare(strict_types=1);

namespace App\Util\Traits;

use App\Interfaces\RepositoryInterface;

/**
 * Trait RepositoryAwareTrait
 * @package App\Util\Traits
 */
trait RepositoryAwareTrait
{
    /**
     * @var RepositoryInterface
     */
    private $repo;

    /**
     * @required
     *
     * @param RepositoryInterface $repo
     */
    public function setRepository(RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return RepositoryInterface
     */
    public function getRepository() : RepositoryInterface
    {
        return $this->repo;
    }
}