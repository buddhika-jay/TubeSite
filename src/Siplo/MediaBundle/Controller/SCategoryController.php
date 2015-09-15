<?php
namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Siplo\MediaBundle\Form\Type\CategoryType;
use Siplo\MediaBundle\Entity\Category;

class SCategoryController extends Controller
{


    /**
     * @Route("/{country}/{category}",requirements={
     *     "country": "^[A-Z]{2}","category":"^[A-Z]{2}"
     * }))
     *
     */
    public function viewSCategoryAction($country,$category)
    {
        $countryEntity = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Country')->findOneByCode($country);
        $categories = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Category')->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No categories found'
            );
        }
        $videos = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Video')->findBy(
                array(),
                array('rating' => 'DESC')
            );
        if (!$videos) {
            return $this->render('AppBundle::emptycontent.html.twig'
            );
        }
        return $this->render('AppBundle::subcategories.html.twig', array(
            'categories' => $categories, 'country' => $countryEntity, 'videos' => $videos));

    }
    /**
     * @Route("/more/{id}")
     *
     */
    public function moreDetailsAction($id){
        return $this->render('AppBundle::detailspage.html.twig');

    }
}