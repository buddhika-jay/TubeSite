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
        $user= $this->get('security.context')->getToken()->getUser();
        $uploader = new PhotoUpload($user);
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
        $user= $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new PhotoUploaderType(), new PhotoUpload($user));

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
     * @Route("/photos/{country}/{category}",requirements={
     *     "country": "^[A-Z]{2}","category":"^[A-Z]{2}"
     * }))
     *
     */
    public function showPhotosAction($country,$category)
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



        $photos = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Photo')->findBy(
                array('country' => $countryID,'category' => $categoryID)
            );;

        if (!$photos) {
            return $this->render('AppBundle::emptycontent.html.twig'
            );
        }

        return $this->render('AppBundle::photos.html.twig',array(
            'photos' => $photos,'country'=>$countryName,'category'=>$categoryName));
    }
}
