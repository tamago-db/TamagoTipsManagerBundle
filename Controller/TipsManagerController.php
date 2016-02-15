<?php

namespace Tamago\TipsManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tamago\TipsManagerBundle\Entity\Tip;

class TipsManagerController extends Controller
{
    public function indexAction()
    {

        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $count = $repository->count();
        $random = random_int(1, $count);
        $tip = $repository->find($random);

        return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ["tip" => $tip]);
    }

    public function lexikAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:Tip');
        $tip = $repository->find(90);
        return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ["tip" => $tip]);
    }

}
