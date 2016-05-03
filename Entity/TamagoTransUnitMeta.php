<?php

namespace Tamago\TipsManagerBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tamago_trans_unit_meta")
 * @ORM\Entity(repositoryClass="Tamago\TipsManagerBundle\Repository\TipRepository")
 */
class TamagoTransUnitMeta
{
    /**
     * @ORM\Column(type="integer", name="lexik_trans_unit_id")
     */
    protected $lexikTransUnitId;

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
     * @ORM\Column(type="string", length=2)
     */
    protected $locale;

    /**
     * @ORM\Column(type="string", name="lexik_key_name")
     */
    protected $key;

    /**
     * @ORM\Column(type="string", name="identifier")
     */
    protected $identifier;

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
    public function getLexikTransUnitId()
    {
        return $this->lexikTransUnitId;
    }

    /**
     * @param mixed $lexikTransUnitTranslation
     */
    public function setLexikTransUnitId($lexikTransUnitId)
    {
        $this->lexikTransUnitId = $lexikTransUnitId;
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

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

}

