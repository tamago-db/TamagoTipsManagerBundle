<?php

namespace TipBundle\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TipBundleTestBundle:Default:index.html.twig');
    }
}
