<?php
/**
 * Created by PhpStorm.
 * User: Sanskriti
 * Date: 12/14/2015
 * Time: 3:37 PM
 */

namespace Tamago\TipsManagerBundle\Repository;

use Doctrine\ORM\EntityRepository;
//use Tamago\TipsManagerBundle\Entity\Tip;
use Lexik\Bundle\TranslationBundle\Entity\Translation;

class TipRepository extends EntityRepository{
    public function count()
    {
        return $this->createQueryBuilder('t')->select('COUNT(t)')->getQuery()->getSingleScalarResult();
    }

    public function stats()
    {
        $s = $this->createQueryBuilder('s')->select('s.id, s.viewCount, s.likes, s.dislikes')->getQuery();
        $stats = $s->getArrayResult();
        return $stats;
    }
}