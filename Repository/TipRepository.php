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
        $s = $this->createQueryBuilder('s')->select('s.id, s.viewCount, s.likes, s.dislikes, s.locale, s.key, s.identifier')->getQuery();
        $stats = $s->getArrayResult();
        return $stats;
    }

    public function singleton($transUnit, $locale, $identifier)
    {
        $metaEntity = $this->findOneBy(['lexikTransUnitId' => $transUnit->getId(), 'locale' => $locale, 'identifier' => $identifier]);
        if(!$metaEntity){
            $metaEntity = new TamagoTransUnitMeta();
            $metaEntity->setLexikTransUnitId($transUnit->getId());
            $metaEntity->setLocale($locale);
            $metaEntity->setLikes(0);
            $metaEntity->setDislikes(0);
            $metaEntity->setViewCount(0);
            $metaEntity->setKey($transUnit->getKey());
            $metaEntity->setIdentifier($identifier);
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

    public function findByLexikJoinedToTamago($domain, $locale, $identifier){
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()->select('ltu')
            ->from('LexikTranslationBundle:TransUnit', 'ltu')
            ->leftJoin('TamagoTipsManagerBundle:TamagoTransUnitMeta','ttu', \Doctrine\ORM\Query\Expr\Join::WITH, 'ltu.id = ttu.lexikTransUnitId')
            ->where('ltu.domain', $domain);

        $result = $query->select()
            ->where('ttu.identifier = :identifier OR ttu.identifier = :nullIdentifier')
            ->andWhere('ttu.locale = :locale OR ttu.locale = :nullLocale')
            ->setParameter('identifier', $identifier)
            ->setParameter('nullIdentifier', null)
            ->setParameter('locale', $locale)
            ->setParameter('nullLocale', null)->getQuery();

        $transUnits = $result->getArrayResult();
        return $transUnits;
    }
}

