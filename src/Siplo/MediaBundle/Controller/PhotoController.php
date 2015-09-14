<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Siplo\MediaBundle\Form\Type\PhotoUploaderType;
use Siplo\MediaBundle\Form\Model\PhotoUpload;
use Siplo\MediaBundle\Entity\Photo;

class PhotoController extends Controller
{
    /**
     * @Route("/upload/photo")
     *
     */
    public function uploadAction()
    {
        $uploader = new PhotoUpload();
        $form = $this->createForm(new PhotoUploaderType(), $uploader, array(
            'action' => '/upload/photo/save',
        ));

        return $this->render(
            'SiploMediaBundle::form.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Route("/upload/photo/save")
     *
     */
    public function saveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new PhotoUploaderType(), new PhotoUpload());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $uploader = $form->getData();

            $em->persist($uploader->getPhoto());
            $em->flush();

            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($uploader->getPhoto(), 'photo');
            return $this->render('SiploMediaBundle::upload_successful.html.twig');
        }

        return $this->render(
            'SiploMediaBundle::form.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/download/photo/{id}")
     *
     */
    public function downloadAction($id)
    {

        $photo = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Photo')
            ->find($id);

        if (!$photo) {
            throw $this->createNotFoundException(
                'No photo found for id '.$id
            );
        }

//        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
//        $path = $this->get('kernel')->getRootDir();#.$helper->asset($photo, 'photo');
//        $path = $this->container->getParameter('vich_uploader.mappings');
//        $path = $path['uploaded_video'];
//        $path = $path['upload_destination'];
//        $path = $path.'dsfasf';

        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $this->get('kernel')->getRootDir(). "/../web/".$helper->asset($photo, 'photo');
        $content = file_get_contents($path);

        $response = new Response();

//        $response->headers->set('Content-Type', '');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$photo->getPhotoFileName());

        $response->setContent($content);
        return $response;
    }

    /**
     * @Route("/test/test")
     *
     */
    public function testPhotoAction()
    {
        $testPath = $this->container->getParameter('vich_uploader.mappings[uploaded_video]. [uri_prefix]');
        return $this->render('@SiploMedia/Default/index.html.twig', array('name'=>$testPath));
    }
}
