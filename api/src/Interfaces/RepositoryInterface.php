<?php

namespace App\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Interface RepositoryInterface
 * @package App\Interfaces
 */
interface RepositoryInterface
{
    /**
     * @return array|Collection|mixed
     */
    public function findAll();

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $item
     * @return mixed
     */
    public function persist($item);

    /**
     * @param $item
     */
    public function remove($item) : void;

}