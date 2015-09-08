<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ImageController extends Controller
{
    /**
     * @Route("/images", name="Images")
     */
    public function imageAction()
    {
        // replace this example code with whatever you need
        $images = array('1'=>'uploads/images/elephants.jpg',
                        '2'=>'uploads/images/Nature.jpg');
        $thumbs = array('1'=>'uploads/images/elephants_thumb.jpg',
            '2'=>'uploads/images/Nature_thumb.jpg');
        return $this->render('SiploMediaBundle::imagegallery.html.twig',array('images'=>$images,'thumbs'=>$thumbs));
    }
}
