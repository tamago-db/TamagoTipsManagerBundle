<?php

namespace Tamago\TipsManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tamago\TipsManagerBundle\Entity\Tip;

class TipsManagerController extends Controller
{
    public function indexAction()
    {
        // @todo Instead of using the 'TamagoTipsManagerBundle:TamagoTransUnitMeta' repository, read tips directly
        // from 'LexikTranslationBundle:TransUnit'

        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $count = $repository->count();
        $random = random_int(1, $count);
        $tip = $repository->find($random);

        // @todo Once a random tip has been retrieved, update meta data via our 'TamagoTipsManagerBundle:TamagoTransUnitMeta'
        // repository
        
        $tip->setViewCount($tip->getViewCount() + 1);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ["tip" => $tip]);
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
    }
}
