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
use Lexik\Bundle\TranslationBundle\Entity\TransUnit;

class TipRepository extends EntityRepository{
    public function count()
    {
        return $this->createQueryBuilder('t')->select('COUNT(t)')->getQuery()->getSingleScalarResult();
    }
}