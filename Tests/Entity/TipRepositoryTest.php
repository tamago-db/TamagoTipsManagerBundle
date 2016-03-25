<?php
/**
 * Created by PhpStorm.
 * User: Sanskriti
 * Date: 12/16/2015
 * Time: 1:36 PM
 */

namespace Tamago\TipsManagerBundle\Tests\Entity;
use Tamago\TipsManagerBundle\Repository\TipRepository;

class TipTest extends \PHPUnit_Framework_TestCase{

    public function testSingleton(){
        $tip = new TipRepository();
        $tip->setId(4);
        $result = $tip->getId();

        $this->assertEquals(4, $result);
    }
}