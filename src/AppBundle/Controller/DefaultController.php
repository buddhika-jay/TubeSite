<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/menu.html.twig');
    }

    /**
     * @Route("/map", name="Map")
     */
    public function mapAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::map.html.twig');
    }

    /**
     * @Route("/video")
     */
    public function videoAction()
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::videopage.html.twig');
    }

//    public function uploadAction()
//    {
//        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
//            return $this->redirectToRoute('siplo_media_video_upload');
//        }
//        else{
//            return $this->redirectToRoute('fos_user_security_login');
//        }
//    }

}
