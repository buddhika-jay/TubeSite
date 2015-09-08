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
        return $this->render('@App/default/index.html.twig');
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
     * @Route("/images", name="Images")
     */
    public function imageAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('SiploMediaBundle::imagegallery.html.twig');
    }
}
