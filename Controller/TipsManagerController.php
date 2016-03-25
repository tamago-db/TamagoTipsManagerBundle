<?php

namespace Tamago\TipsManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TipsManagerController extends Controller
{
    public function indexAction(Request $request)
    {
        $repositoryTransUnit = $this->getDoctrine()->getManager()->getRepository('LexikTranslationBundle:TransUnit');

        $transUnits = $repositoryTransUnit->findByDomain('tips-general');

        // 404 if no tips
        if (!$total = count($transUnits)) {
            return new Response('');
        }

        // Get a random tip
        $random = random_int(0, $total-1);
        $transUnit = $transUnits[$random];

        // 404 if no translation for selected tip
        // @todo Implement a fallback or limit query to tips with translations
        if (!$transUnit->hasTranslation($request->getLocale())) {
            return new Response('');
        }

        // Retrieve meta data
        $repositoryTamago = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $metaEntity = $repositoryTamago->singleton($transUnit, $request->getLocale());


        // Increment view count
        $metaEntity->setViewCount($metaEntity->getViewCount() + 1);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ['tip' => $transUnit]);
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
