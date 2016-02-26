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
     * @ORM\OneToOne(targetEntity="Lexik\Bundle\TranslationBundle\Entity\TransUnit")
     * @ORM\JoinColumn(name="lexik_trans_unit_id", referencedColumnName="id")
     */
    protected $lexikTransUnit;

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
     * @ORM\Column(type="integer", name="view_count")
     */
    protected $viewCount;

    /**
     * @return mixed
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param mixed $viewCount
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param mixed $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return mixed
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * @param mixed $dislikes
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;
    }

    /**
     * @return mixed
     */
    public function getLexikTransUnit()
    {
        return $this->lexikTransUnit;
    }

    /**
     * @param mixed $lexikTransUnitTranslation
     */
    public function setLexikTransUnit($lexikTransUnit)
    {
        $this->lexikTransUnit = $lexikTransUnit;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}