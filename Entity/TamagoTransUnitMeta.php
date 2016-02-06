<?php
/**
 * Created by PhpStorm.
 * User: Sanskriti
 * Date: 12/17/2015
 * Time: 5:13 PM
 */

namespace Tamago\TipsManagerBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\TranslationBundle\Entity\Translation;

/**
 * @ORM\Table(name="tamago_trans_unit_meta")
 * @ORM\Entity(repositoryClass="Tamago\TipsManagerBundle\Repository\TipRepository")
 */
class TamagoTransUnitMeta
{
    /**
     * @ORM\OneToOne(targetEntity="Lexik\Bundle\TranslationBundle\Entity\Translation")
     * @ORM\JoinColumn(name="lexik_trans_unit_translation_id", referencedColumnName="id")
     */
    protected $lexikTransUnitTranslation;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $likes;

    /**
     * @ORM\Column(type="integer")
     */
    protected $dislikes;

    /**
     * @ORM\Column(type="integer")
     */
    protected $viewCount;

    /**
     * @return mixed
     */
    public function getLexikTransUnitTranslation()
    {
        return $this->lexikTransUnitTranslation;
    }

    /**
     * @param mixed $lexikTransUnitTranslation
     */
    public function setLexikTransUnitTranslation($lexikTransUnitTranslation)
    {
        $this->lexikTransUnitTranslation = $lexikTransUnitTranslation;
    }

}