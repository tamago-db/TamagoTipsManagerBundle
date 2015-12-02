<?php

namespace Tamago\TipsManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TipsManagerController extends Controller
{
    public function indexAction()
    {
        $tip = "Dummy Tip";
        return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ["tip" => $tip]);
    }
}
