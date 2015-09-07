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

            return $this->redirectToRoute("/play/");
        }

        return $this->render(
            'SiploMediaBundle::form.html.twig',
            array('form' => $form->createView())
        );
    }
}
