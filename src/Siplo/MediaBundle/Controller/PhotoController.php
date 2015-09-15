<?php

namespace Siplo\MediaBundle\Controller;

use Siplo\MediaBundle\Form\Type\PhotoType;
use Siplo\MediaBundle\Form\Type\TestPhotoUpload;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Siplo\MediaBundle\Entity\Photo;

class PhotoController extends Controller
{

    /**
     * @Route("/upload/photo")
     *
     */
    public function uploadAction(Request $request)
    {

        $form = $this->createForm(new PhotoType(), new Photo());
        $form->handleRequest($request);
        if ($form->isValid()) {


            $photo = $form->getData();
            $user= $this->get('security.context')->getToken()->getUser();
            $photo->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($photo, 'photo');
            return $this->render('SiploMediaBundle::upload_successful.html.twig');

        }

        return $this->render(
            '@SiploMedia/form.html.twig',
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


        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $this->get('kernel')->getRootDir(). "/../web/".$helper->asset($photo, 'photo');
        $content = file_get_contents($path);

        $response = new Response();

//        $response->headers->set('Content-Type', '');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$photo->getPhotoFileName());

        $response->setContent($content);
        return $response;
    }
}
