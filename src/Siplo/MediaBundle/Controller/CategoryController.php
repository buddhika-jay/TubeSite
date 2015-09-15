<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Siplo\MediaBundle\Form\Type\CategoryType;
use Siplo\MediaBundle\Entity\Category;

class CategoryController extends Controller
{


    /**
     * @Route("/{country}",requirements={
     *     "country": "^[A-Z]{2}"
     * }))
     *
     */
    public function viewCategoryAction($country)
    {
        $countryEntity=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:Country')->findOneByCode($country);
        $categories = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Category')->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No categories found'
            );
        }
        $videos = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Video')->findAll();
        if (!$videos) {
            return $this->render('AppBundle::emptycontent.html.twig'
            );
        }
        return $this->render('AppBundle::categories.html.twig',array(
            'categories' => $categories,'country'=>$countryEntity,'videos'=>$videos));

    }



    /**
     * @Route("/create/category")
     *
     */
    public function createAction(Request $request)
    {

        $form = $this->createForm(new CategoryType(), new Category());
        $form->handleRequest($request);
        if ($form->isValid()) {


            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->render('SiploMediaBundle::upload_successful.html.twig');

        }

        return $this->render(
            '@SiploMedia/form.html.twig',
            array('form' => $form->createView())
        );

    }
}
