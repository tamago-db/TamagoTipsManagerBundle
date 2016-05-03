<?php

namespace Tamago\TipsManagerBundle\Controller;

use Lexik\Bundle\TranslationBundle\Model\TransUnit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class TipsManagerController extends Controller
{
    /**
     * Retrieve a random tip from the Lexik translations.  Increment view count.
     *
     * @param Request $request
     * @return TransUnit
     */
    private function getTipTransUnit(Request $request, $domain)
    {
        $transUnitRepository = $this->getDoctrine()->getManager()->getRepository('LexikTranslationBundle:TransUnit');

        // Note that getAllByLocaleAndDomain return arrays rather than entities; presumably for performance reasons
        $transUnits = $transUnitRepository->getAllByLocaleAndDomain($request->getLocale(), $domain);

        // Throw exception if not tips
        if (!$total = count($transUnits)) {
            throw new \RuntimeException('No tips in database');
        }

        $session = $request->getSession();
        $session->all();

        // Get a random tip from the array
        $random = random_int(0, $total-1);
//        $tips = array("newtip1", "nexttip", "firsttip", "secondtip");
//        $ajay = $tips[2];
//        echo $ajay;

        // Now retrieve a single TransUnit entity
        $transUnitId = $transUnits[$random]['id'];
        $transUnit = $transUnitRepository->find($transUnitId);

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
    public function indexAction(Request $request, $domain)
    {
        try {
            $transUnit = $this->getTipTransUnit($request, $domain);
            $tipStack = $request->getSession()->get('tip_stack', []);
            $tipStack[] = $transUnit;
            $request->getSession()->set('tip_stack', $tipStack);

            return $this->render('TamagoTipsManagerBundle:Default:index.html.twig', ['tip' => $transUnit]);



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
     * @return Response
     */
    public function feedbackAction($id, $feedback, $domain, Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TamagoTipsManagerBundle:TamagoTransUnitMeta');
        $tip = $repository->findOneBy(array('lexikTransUnitId' => $id, 'locale' => $request->getLocale()));
//       if($domain == 'dislike')
//        {
//            $dislike = $id;
//
//      }
//        $session = $request->getSession();
//        $session->set('dislike', 'ajay');
//        $session->get('dislike');
//        $session = $request->getSession();
//           $session->set('name', $id);
//        $session->get('name');
        switch ($feedback) {
            case 'like':
                $tip->setLikes($tip->getLikes() + 1);
                break;
            case 'dislike':
                $tip->setDislikes($tip->getDislikes() + 1);

                break;
        }

        $this->getDoctrine()->getManager()->flush();

        $transUnit = $this->getTipTransUnit($request, $domain);
        return $this->render('TamagoTipsManagerBundle:Default:tip.html.twig', ['tip' => $transUnit, 'domain' => $domain]);
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

    public function prevAction($id, $domain, Request $request)
    {
        $tipStack = $request->getSession()->get('tip_stack');
        dump($tipStack[count($tipStack)-1]);
        empty($tipStack[count($tipStack)-1]);
        $request->getSession()->set('tip_stack', $tipStack);
        exit;

        $session = $request->getSession();

//        $count = $session->get('count');
        $count = 1;
        $count++;
//        $session->set('count', $count);
global $prevtips;
        $prevtips = $session->get('prev', []);
        $prevtips[] = $id;
        $session->set('prev', $prevtips);
        $session->get('prev');
//        $ajay = $session->get('prev');
//        return 'prev' ;
       // return $prevtips;
        //$os = array("Mac", "NT", "Irix", "Linux");
//        if (in_array("Irix", $os)) {
//            echo "Got Irix";
//        }
//        if (in_array("mac", $os)) {
//            echo "Got mac";
        //}

//        $value = $session->get('prev');
//        $lastValue = array_pop($value);
//
//        $tips = array("newtip", "nexttip", "firsttip", "secondtip");
//           $n1 = count($prevtips);
//        $ajay = $prevtips[$n1-$count];
      $transUnit = $this->getTipTransUnit($request, $domain);
////        if(in_array($transUnit, $prevtips)) {
//            echo $id;
//
//        }



           return $this->render('TamagoTipsManagerBundle:Default:tip.html.twig', ['tip' => $transUnit, 'domain' => $domain]);


    }
//    public function nextAction($domain, Request $request)
//    {
//        die('next');
////        $number2 = $number2+1;
////        $number = $number2;
//       $tips = array("newtip", "nexttip", "firsttip", "secondtip", "thiredtip", "fourthtip", "fifthtip", "sixthtip", "seventhtip");
//        $n1 = count($tips);
////        if($number == NULL) {
////            $ajay = $tips[$n1 - 1];
////            $number3 = 1;
////        }
////        else {
////            $ajay = $tips[$n1 - $number2];
////            $number3 = 1;
////        }
////        $a = $tips.length;
////        $ajay = $tips[$n1-1];
//        $ajay = 4;
//
//        $transUnit = $this->getTipTransUnit($request, $domain);
//        return $this->render('TamagoTipsManagerBundle:Default:tip.html.twig', ['tip' => $transUnit, 'domain' => $domain, 'tip1' => $ajay]);
//    }
}
