<?php
/**
 * Created by PhpStorm.
 * User: Sanskriti
 * Date: 12/14/2015
 * Time: 3:37 PM
 */

namespace Tamago\TipsManagerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\TranslationBundle\Entity\Translation;
use Tamago\TipsManagerBundle\Entity\TamagoTransUnitMeta;

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

    public function singleton($transUnit)
    {
        $metaEntity = $this->findOneBy($transUnit->getId());
        if(!$metaEntity){
            $metaEntity = new TamagoTransUnitMeta();
            $metaEntity->setLexikTransUnitId($transUnit->getId());
            $metaEntity->setLocale($transUnit->getLocale());
            $em = $this->getEntityManager();
            $em->persist($metaEntity);
            $em->flush();
        }
        return $metaEntity;
    }
}
