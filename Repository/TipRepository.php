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
        /*$query = $em->createQuery(
                'SELECT sub.id, sub.domain, sub.lexik_trans_unit_id, sub.locale, sub.identifier
                 FROM

                (SELECT ltu.id, ltu.domain, ttu.lexik_trans_unit_id, ttu.locale, ttu.identifier
                FROM LexikTranslationBundle:TransUnit ltu left join TamagoTipsManagerBundle:TamagoTransUnitMeta ttu
                ON ltu.id = ttu.lexik_trans_unit_id
                WHERE ltu.domain = :domain) AS sub

                WHERE (sub.identifier = :identifier OR sub.identifier IS NULL)
                AND (sub.locale = :locale OR sub.locale IS NULL)'
                )->setParameter('domain', $domain)->setParameter('identifier', $identifier)->setParameter('locale', $locale);*/

        $subQuery = $em->createQueryBuilder('ltu')->select('ltu.id', 'ltu.domain', 'ttu.lexik_trans_unit_id', 'ttu.locale', 'ttu.identifier')
            ->from('LexikTranslationBundle:TransUnit', 'ltu')
            ->leftJoin('ltu', 'TamagoTipsManagerBundle:TamagoTransUnitMeta', 'ttu', 'ltu.id = ttu.lexik_trans_unit_id')
            ->where('ltu.domain', $domain);

        $result = $subQuery->select('id', 'domain', 'lexik_trans_unit_id', 'locale', 'identifier')
            ->where('identifier', $identifier)->orWhere('identifier', null)
            ->andWhere('locale', $locale)->orWhere('locale', null)->getQuery();

        $transUnits = $result->getArrayResult();
        return $transUnits;
    }
}

