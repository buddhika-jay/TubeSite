<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Siplo\MediaBundle\Entity\Photo;
use Siplo\MediaBundle\Form\Type\PhotoType;
use Siplo\MediaBundle\Form\Type\PhotoCountrySelectType;

class PhotoController extends Controller
{

    /**
     * @Route("/upload/photo")
     *
     */
    public function uploadAction(Request $request)
    {

        $form = $this->createForm(new PhotoCountrySelectType(), new Photo());
        $form->handleRequest($request);
        if ($form->isValid()) {

            $photo = $form->getData();
            return $this->redirect("/upload/photo/".$photo->getCountry()->getId());

        }

        return $this->render(
            '@SiploMedia/form.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route("/upload/photo/{countryId}")
     *
     */
    public function editAction($countryId)
    {
        $request = $this->get('request');

        $em = $this->getDoctrine()->getEntityManager();
        $country = $em->getRepository('SiploMediaBundle:Country')->find($countryId);
        $photo = new Photo();
        $photo->setCountry($country);
        $form = $this->createForm(new PhotoType(), $photo);
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
     * @Route("/{country}/{category}/photos/{subcategory}",requirements={
     *     "country": "^[A-Z]{2}","category":"^[A-Z]{2}"
     * }))
     *
     */
    public function showPhotosAction($country,$category,$subcategory)
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

//        get subcategory entity
        $subcategoryEntity=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:SubCategory')->findOneByCode($subcategory);
        $subcategoryID=$subcategoryEntity->getId();

        $photos = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Photo')->findBy(
                array('authorised'=>true,'country' => $countryID,'category' => $categoryID,'subCategory'=>$subcategoryID)
            );;

        if (!$photos) {
            return $this->render('AppBundle::emptycontent.html.twig'
            );
        }

        return $this->render('AppBundle::photos.html.twig',array(
            'photos' => $photos,'country'=>$countryName,'category'=>$categoryName,'subcategory'=>$subcategoryEntity));
    }
}
