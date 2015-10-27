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

    /**
     * @Route("/{country}/{category}",requirements={
     *     "country": "(?<![-.])\b[0-9]+\b(?!\.[0-9])","category":"(?<![-.])\b[0-9]+\b(?!\.[0-9])"
     * }))
     *
     */
    public function viewSCategoryAction($country,$category)
    {
        $countryEntity = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Country')->findOneById($country);

        $categoryEntity = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Category')->findOneById($category);

        $subCategories = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:SubCategory')->findBy(array('country'=>$countryEntity->getId(),'category'=>$categoryEntity->getId()));

        if (!$subCategories) {
            $this->render('AppBundle::emptycontent.html.twig');
        }
        $videos = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Video')->findBy(
                array('authorised'=>true,'country'=>$countryEntity->getId(),'category'=>$categoryEntity->getId()),
                array('rating' => 'DESC')
            );
        if (!$videos) {
            return $this->render('AppBundle::emptycontent.html.twig'
            );
        }
        return $this->render('AppBundle::subcategories.html.twig', array(
            'subCategories' => $subCategories, 'country' => $countryEntity,'category'=>$categoryEntity,'videos' => $videos));

    }
    /**
     * @Route("/more/{id}")
     *
     */
    public function moreDetailsAction($id){
        $details = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:FurtherDetails')->findBy(
                array('subCategory'=>$id)
            );
        if (!$details) {
            return $this->render('AppBundle::emptycontent.html.twig'
            );
        }
        return $this->render('AppBundle::detailspage.html.twig',array('details'=>$details));

    }
}
