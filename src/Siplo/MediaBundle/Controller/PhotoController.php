<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Siplo\MediaBundle\Entity\Photo;
use Siplo\MediaBundle\Form\Type\PhotoType;

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

            return $this->render('SiploMediaBundle::upload_successful.html.twig');

        }

        return $this->render(
            '@SiploMedia/form.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route("/edit/photo/{id}")
     *
     */
    public function editAction($id)
    {
        $request = $this->get('request');

        $em = $this->getDoctrine()->getEntityManager();
        $photo = $em->getRepository('SiploMediaBundle:Photo')->find($id);

        $form = $this->createForm(new PhotoType(), $photo);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $photo = $form->getData();

            //go to second form

            $categories = $photo->getCountry()->getCategories();
            $subCategories = $photo->getCountry()->getSubCategories();

            $form2 = $this->createForm(new PhotoType(), $photo);
            $form2->handleRequest($request);


            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

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
