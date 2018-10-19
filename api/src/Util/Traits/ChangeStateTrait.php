<?php

namespace App\Util\Traits;

/**
 * Trait ChangeStateTrait
 * @package App\Util\Traits($item)
 */
trait ChangeStateTrait
{

    public function persist($item)
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function remove($item): void
    {
        $this->_em->remove($item);
        $this->_em->flush();
    }

}