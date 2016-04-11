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
     * @param $domain
     * @param $identifier
     * @return TransUnit
     */
    private function getTipTransUnit(Request $request, $domain, $identifier)
    {
        //$transUnitRepository = $this->getDoctrine()->getManager()->getRepository('LexikTranslationBundle:TransUnit');
        $transUnitRepository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');

        // Note that getAllByLocaleAndDomain return arrays rather than entities; presumably for performance reasons
        //$transUnits = $transUnitRepository->getAllByLocaleAndDomain($request->getLocale(), $domain);

        $transUnits = $transUnitRepository->findByLexikJoinedToTamago($domain, $request->getLocale(), $identifier);

        // Throw exception if not tips
        if (!$total = count($transUnits)) {
            throw new \RuntimeException('No tips in database');
        }

        // Get a random tip from the array
        $random = random_int(0, $total-1);

        // Now retrieve a single TransUnit entity
        $transUnitId = $transUnits[$random]['id'];
        $transUnit = $transUnitRepository->find($transUnitId);

        // Retrieve meta data
        $repositoryTamago = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $metaEntity = $repositoryTamago->singleton($transUnit, $request->getLocale(), $identifier);

        // Increment view count
        $metaEntity->setViewCount($metaEntity->getViewCount() + 1);
        $this->getDoctrine()->getManager()->flush();

        return $transUnit;
    }

    /**
     * Render tip page with style and JavaScript.
     *
     * @param Request $request
     * @param $domain
     * @param $identifier
     * @return Response
     */
    public function indexAction(Request $request, $domain, $identifier)
    {
        try {
            $transUnit = $this->getTipTransUnit($request, $domain, $identifier);
            return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ['tip' => $transUnit, 'identifier' => $identifier]);
        } catch (\RuntimeException $e) {
            // Catch exception and return 204
            return new Response(null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Record feedback for given tip and return a new tip div block to be rendered via jQuery.
     *
     * @param $id
     * @param $feedback
     * @param Request $request
     * @param $domain
     * @param $identifier
     * @return Response
     */
    public function feedbackAction($id, $feedback, $domain, Request $request, $identifier)
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

        $transUnit = $this->getTipTransUnit($request, $domain, $identifier);
        return $this->render('TamagoTipsManagerBundle:Default:tip.html.twig', ['tip' => $transUnit, 'domain' => $domain, 'identifier' => $identifier]);
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
