<?php
/**
 * Created by PhpStorm.
 * User: Sanskriti
 * Date: 12/14/2015
 * Time: 3:37 PM
 */

namespace Tamago\TipsManagerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tamago\TipsManagerBundle\Entity\TamagoTransUnitMeta;

class TipRepository extends EntityRepository
{
    public function count()
    {
        return $this->createQueryBuilder('t')->select('COUNT(t)')->getQuery()->getSingleScalarResult();
    }

    public function stats()
    {
        $s = $this->createQueryBuilder('s')->select('s.id, s.viewCount, s.likes, s.dislikes, s.locale, s.key')->getQuery();
        $stats = $s->getArrayResult();
        return $stats;
    }

    public function singleton($transUnit, $locale)
    {
        $metaEntity = $this->findOneBy(['lexikTransUnitId' => $transUnit->getId(), 'locale' => $locale]);
        if(!$metaEntity){
            $metaEntity = new TamagoTransUnitMeta();
            $metaEntity->setLexikTransUnitId($transUnit->getId());
            $metaEntity->setLocale($locale);
            $metaEntity->setLikes(0);
            $metaEntity->setDislikes(0);
            $metaEntity->setViewCount(0);
            $metaEntity->setKey($transUnit->getKey());
            $em = $this->getEntityManager();
            $em->persist($metaEntity);
            $em->flush();
        }
        return $metaEntity;
    }

    public function getTranslationId($transUnitId){
        $t = $this->createQueryBuilder('t')->select('t.id')->where('t.transUnitId', $transUnitId)->getQuery();
        return $t;
    }
}

