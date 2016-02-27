<?php

namespace Tamago\TipsManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tamago\TipsManagerBundle\Entity\Tip;

class TipsManagerController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('LexikTranslationBundle:TransUnit');
        $count = $repository->count();
        $random = random_int(1, $count);
        $transUnit = $repository->find($random);

        // @todo Once a random tip has been retrieved, update meta data via our 'TamagoTipsManagerBundle:TamagoTransUnitMeta'
        // repository

        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $metaEntity = $repository->singleton($transUnit);

        $metaEntity->setViewCount($metaEntity->getViewCount() + 1);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ["tip" => $transUnit]);
    }

    public function feedbackAction($id, $feedback)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $tip = $repository->find($id);

        switch($feedback){
            case 'like': $tip->setLikes($tip->getLikes() + 1);
                break;
            case 'dislike': $tip->setDislikes($tip->getDislikes() + 1);
                break;
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('tip_bundle_homepage'));
    }

    public function statsAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $stats = $repository->stats();
        return $this->render('TamagoTipsManagerBundle:Default:stats.html.twig', ["stats" => $stats]);
    }
}
