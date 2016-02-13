<?php
/**
 * Created by PhpStorm.
 * User: Sanskriti
 * Date: 12/14/2015
 * Time: 3:37 PM
 */

namespace Tamago\TipsManagerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tamago\TipsManagerBundle\Entity\Tip;

class TipRepository extends EntityRepository{
    public function count()
    {
        return $this->createQueryBuilder('t')->select('COUNT(t)')->getQuery()->getSingleScalarResult();
    }

    public function updateViewCount($id)
    {
        $this->createQueryBuilder('t')->update('t')->set('t.viewCount', 't.viewCount + 1')->where('t.id = ?1')->setParameter(1, $id)->getQuery();

    }
}