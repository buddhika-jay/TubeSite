<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Siplo\MediaBundle\Form\Type\UploaderType;
use Siplo\MediaBundle\Form\Model\Upload;

class VideoController extends Controller
{
    /**
     * @Route("/{country}/{category}",requirements={
     *     "country": "^[A-Z]{2}","category":"^[A-Z]{2}"
     * }))
     *
     */
    public function showVideosAction($country,$category)
    {

        //        find country id
        $countryEntiy=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:Country')->findOneByCode($country);
        $countryID=$countryEntiy->getId();
        $countryName=$countryEntiy->getName();


//        find categroy id
        $categoryEntity=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:Category')->findOneByCode($category);
        $categoryID=$categoryEntity->getId();

        $categoryName=$categoryEntity->getTitle();



        $videos = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Video')->findBy(
                array('country' => $countryID,'category' => $categoryID)
            );;

        if (!$videos) {
            return $this->render('AppBundle::emptycontent.html.twig'
            );
        }

        return $this->render('AppBundle::videos.html.twig',array(
            'videos' => $videos,'country'=>$countryName,'category'=>$categoryName));
    }
    /**
     * @Route("/play/{id}")
     * @Template()
     */
    public function playAction($id=1)
    {
        $video = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Video')
            ->find($id);

        if (!$video) {
            throw $this->createNotFoundException(
                'No video found for id '.$id
            );
        }
//        $path= $video;//->getVideoFile();//.mozFullPath;

        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($video, 'videoFile');


        //$path = "videos/sample.mp4";
        return $this->render('SiploMediaBundle::videoplayer.html.twig',array(
            'path' => $path));
    }

    /**
     * @Route("/upload")
     *
     */
    public function uploadAction()
    {
        $uploader = new Upload();
        $form = $this->createForm(new UploaderType(), $uploader, array(
            'action' => '/upload/save',
        ));

        return $this->render(
            'SiploMediaBundle::form.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Route("/upload/save")
     *
     */
    public function saveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new UploaderType(), new Upload());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $uploader = $form->getData();

            $em->persist($uploader->getVideo());
            $em->flush();

            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($uploader->getVideo(), 'videoFile');
//            return $this->redirectToRoute('play');
            return $this->render('SiploMediaBundle::videoplayer.html.twig',array(
                'path' => $path));
        }

        return $this->render(
            'SiploMediaBundle::form.html.twig',
            array('form' => $form->createView())
        );
    }
}
