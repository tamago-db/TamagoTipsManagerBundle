<?php

namespace Tamago\TipsManagerBundle\Controller;

use Lexik\Bundle\TranslationBundle\Model\TransUnit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TipsManagerController extends Controller
{
    /**
     * Retrieve a random tip from the Lexik translations.  Increment view count.
     *
     * @param Request $request
     * @return TransUnit
     */
    private function getTipTransUnit(Request $request)
    {
        $repositoryTransUnit = $this->getDoctrine()->getManager()->getRepository('LexikTranslationBundle:TransUnit');

        $transUnits = $repositoryTransUnit->findByDomain('tips-general');

        // 404 if no tips
        if (!$total = count($transUnits)) {
            throw new \RuntimeException('No tips in database');
        }

        // Get a random tip
        $random = random_int(0, $total-1);
        $transUnit = $transUnits[$random];

        // 404 if no translation for selected tip
        // @todo Implement a fallback or limit query to tips with translations
        if (!$transUnit->hasTranslation($request->getLocale())) {
            throw new \RuntimeException('Tip not translated');
        }

        // Retrieve meta data
        $repositoryTamago = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $metaEntity = $repositoryTamago->singleton($transUnit, $request->getLocale());

        // Increment view count
        $metaEntity->setViewCount($metaEntity->getViewCount() + 1);
        $this->getDoctrine()->getManager()->flush();

        return $transUnit;
    }

    /**
     * Render tip page with style and JavaScript.
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $transUnit = $this->getTipTransUnit($request);
        return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ['tip' => $transUnit]);
    }

    /**
     * Record feedback for given tip and return a new tip div block to be rendered via jQuery.
     *
     * @param $id
     * @param $feedback
     * @param Request $request
     * @return Response
     */
    public function feedbackAction($id, $feedback, Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $tip = $repository->findOneBy(array('lexikTransUnitId' => $id, 'locale' => $request->getLocale()));

        switch ($feedback) {
            case 'like':
                $tip->setLikes($tip->getLikes() + 1);
                break;
            case 'dislike':
                $tip->setDislikes($tip->getDislikes() + 1);
                break;
        }
        $this->getDoctrine()->getManager()->flush();

        $transUnit = $this->getTipTransUnit($request);
        return $this->render('TamagoTipsManagerBundle:Default:tip.html.twig', ['tip' => $transUnit]);
    }

    /**
     * Render stats page.
     *
     * @return Response
     */
    public function statsAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $stats = $repository->stats();

        return $this->render('TamagoTipsManagerBundle:Default:stats.html.twig', ['stats' => $stats]);
    }
}
