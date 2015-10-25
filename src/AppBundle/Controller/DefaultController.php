<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{


    /**
     * @Route("/video")
     */
    public function videoAction()
    {
        // replace this example code with whatever you need
        return $this->render('SiploMediaBundle::country.html.twig');
    }


    /**
     * @Route("/test")
     */
    public function testAction()
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::countryselector.html.twig');
    }


}
