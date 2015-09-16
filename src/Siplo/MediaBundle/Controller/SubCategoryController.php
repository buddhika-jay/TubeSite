<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Siplo\MediaBundle\Form\Type\SubCategoryType;
use Siplo\MediaBundle\Entity\SubCategory;

class SubCategoryController extends Controller
{

//  Copied from Category Controller

//    /**
//     * @Route("/{country}",requirements={
//     *     "country": "^[A-Z]{2}"
//     * }))
//     *
//     */
//    public function viewCategoryAction($country)
//    {
//        $countryEntity=$this->getDoctrine()
//            ->getRepository('SiploMediaBundle:Country')->findOneByCode($country);
//        $categories = $this->getDoctrine()
//            ->getRepository('SiploMediaBundle:Category')->findAll();
//
//        if (!$categories) {
//            throw $this->createNotFoundException(
//                'No categories found'
//            );
//        }
//
//        $videos = $this->getDoctrine()
//            ->getRepository('SiploMediaBundle:Video')->findAll();
//        if (!$videos) {
//            return $this->render('AppBundle::emptycontent.html.twig'
//            );
//        }
//        return $this->render('AppBundle::categories.html.twig',array(
//            'categories' => $categories,'country'=>$countryEntity,'videos'=>$videos));
//    }



    /**
     * @Route("/create/subcategory")
     *
     */
    public function createAction(Request $request)
    {

        $form = $this->createForm(new SubCategoryType(), new SubCategory());
        $form->handleRequest($request);
        if ($form->isValid()) {


            $subcategory = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($subcategory);
            $em->flush();

            return $this->render('SiploMediaBundle::upload_successful.html.twig');

        }

        return $this->render(
            '@SiploMedia/form.html.twig',
            array('form' => $form->createView())
        );

    }
}
