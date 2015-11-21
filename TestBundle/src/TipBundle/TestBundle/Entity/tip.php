<?php
/**
 * Created by PhpStorm.
 * User: Sanskriti
 * Date: 11/20/2015
 * Time: 3:39 PM
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tip")
 */
class Tip
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $tip;

    /**
     * @ORM\Column(type="string", length=2)
     */
    protected $language;


    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getTip()
    {
        return $this->tip;
    }


    public function setTip($tip)
    {
        $this->tip = $tip;
    }


    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

}