<?php
/**
 * Created by PhpStorm.
 * User: Sanskriti
 * Date: 12/16/2015
 * Time: 1:36 PM
 */

namespace Tamago\TipsManagerBundle\Tests\Entity;
use Tamago\TipsManagerBundle\Entity\Tip;

class TipTest extends \PHPUnit_Framework_TestCase{

    public function testGetId(){
        $tip = new Tip();
        $tip->setId(4);
        $result = $tip->getId();

        $this->assertEquals(4, $result);
    }
}