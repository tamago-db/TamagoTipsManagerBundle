<?php

namespace Tamago\TipsManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TipsManagerController extends Controller
{
    public function indexAction()
    {
        //$tip = "Dummy Tip";
        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:Tip');
        $tip = $repository->find(1);
        return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ["tip" => $tip]);
    }
}
