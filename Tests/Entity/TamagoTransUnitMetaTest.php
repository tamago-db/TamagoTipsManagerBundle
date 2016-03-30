<?php

namespace Tamago\TipsManagerBundle\Tests\Entity;

use Tamago\TipsManagerBundle\Entity\TamagoTransUnitMeta;

class TamagoTransUnitMetaTest extends \PHPUnit_Framework_TestCase
{
    public function testLocale()
    {
        $meta = new TamagoTransUnitMeta();
        $this->assertNull($meta->getLocale());
        $meta->setLocale('en');
        $this->assertEquals('en', $meta->getLocale());
    }
}
