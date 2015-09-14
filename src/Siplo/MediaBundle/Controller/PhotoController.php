<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Siplo\MediaBundle\Form\Type\PhotoUploaderType;
use Siplo\MediaBundle\Form\Model\PhotoUpload;

class PhotoController extends Controller
{
    /**
     * @Route("/upload/photo")
     *
     */
    public function photoUploadAction()
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
            return $this->render('SiploMediaBundle::videoplayer.html.twig',array(
                'path' => $path));
        }

        return $this->render(
            'SiploMediaBundle::form.html.twig',
            array('form' => $form->createView())
        );
    }
}
