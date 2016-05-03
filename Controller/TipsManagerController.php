<?php

namespace Tamago\TipsManagerBundle\Controller;

use Doctrine\ORM\Query\QueryException;
use Lexik\Bundle\TranslationBundle\Model\TransUnit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TipsManagerController extends Controller
{
    private function getObjectManager()
    {
        $storage = $this->get('lexik_translation.translation_storage');
        $refStorage = new \ReflectionObject($storage);
        $refMethod = $refStorage->getMethod('getManager');
        $refMethod->setAccessible('public');  // Make it public
        return $refMethod->invoke($storage);
    }

    /**
     * Retrieve a random tip from the Lexik translations.  Increment view count.
     *
     * @param Request $request
     * @param $domain
     * @param $identifier
     * @return TransUnit
     */
    private function getTipTransUnit($locale, $domain, $identifier)
    {
        $storage = $this->get('lexik_translation.translation_storage');
        try {
            // Note that getAllByLocaleAndDomain return arrays rather than entities; presumably for performance reasons
            $transUnits = $storage->getTransUnitsByLocaleAndDomain($locale, $domain);
        } catch (QueryException $e) {
            throw new \RuntimeException('Tips database not configured');
        }

        // Throw exception if not tips
        if (!$total = count($transUnits)) {
            throw new \RuntimeException('No tips in database');
        }

        // Get a random tip from the array
        $random = random_int(0, $total-1);

        // Now retrieve a single TransUnit entity
        $transUnitId = $transUnits[$random]['id'];
        $transUnit = $storage->getTransUnitById($transUnitId);

        // Retrieve meta data
        $om = $this->getObjectManager();
        $tipMetaDataRepository = $om->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $tipMetaData = $tipMetaDataRepository->singleton($transUnit, $locale, $identifier);

        // Increment view count
        $tipMetaData->setViewCount($tipMetaData->getViewCount() + 1);
        $om->flush();

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
        $locale = substr($request->getLocale(), 0, 2);  // Make sure to use only the two character locale
        try {
            $transUnit = $this->getTipTransUnit($locale, $domain, $identifier);
            $translatedTip = $transUnit->getTranslation($locale);
            return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', [
                'tip' => $translatedTip, 'identifier' => $identifier
            ]);
        } catch (\RuntimeException $e) {
            // Catch exception and return 204
            return new Response(null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Record feedback for given tip and return a new tip div block to be rendered via jQuery.
     *
     * @param Request $request
     * @param $id
     * @param $feedback
     * @param $domain
     * @param $identifier
     * @return Response
     */
    public function feedbackAction(Request $request, $id, $feedback, $domain, $identifier)
    {
        $locale = substr($request->getLocale(), 0, 2);  // Make sure to use only the two character locale

        $om = $this->getObjectManager();
        $repository = $om->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $tipMetaData = $repository->findOneBy(['lexikTransUnitId' => $id, 'locale' => $locale, 'identifier' => $identifier]);

        switch ($feedback) {
            case 'like':
                $tipMetaData->setLikes($tipMetaData->getLikes() + 1);
                break;
            case 'dislike':
                $tipMetaData->setDislikes($tipMetaData->getDislikes() + 1);
                break;
        }
        $om->flush();

        $transUnit = $this->getTipTransUnit($locale, $domain, $identifier);
        $translatedTip = $transUnit->getTranslation($locale);

        return $this->render('TamagoTipsManagerBundle:Default:tip.html.twig', [
            'tip' => $translatedTip, 'identifier' => $identifier
        ]);
    }

    /**
     * Render stats page.
     *
     * @return Response
     */
    public function statsAction()
    {
        $om = $this->getObjectManager();
        $repository = $om->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $stats = $repository->stats();

        return $this->render('TamagoTipsManagerBundle:Default:stats.html.twig', ['stats' => $stats]);
    }
}
