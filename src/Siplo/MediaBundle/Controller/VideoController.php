<?php

namespace Siplo\MediaBundle\Controller;

use Siplo\MediaBundle\Form\Type\Video2Type;
use Siplo\MediaBundle\Form\Type\VideoCategorizeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Siplo\MediaBundle\Form\Type\VideoType;
use Siplo\MediaBundle\Entity\Video;

class VideoController extends Controller
{
    /**
     * @Route("/{country}/{category}/videos/{subcategory}",requirements={
     *     "country": "^[A-Z]{2}","category":"^[A-Z]{2}","subcategory":"^[A-Z]{2}"
     * }))
     *
     */
    public function showVideosAction($country,$category,$subcategory)
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


        $videos = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Video')->findBy(
                array('authorised'=>true,'country' => $countryID,'category' => $categoryID,'subCategory'=>$subcategoryID),
                array('rating' => 'DESC')
            );;

        if (!$videos) {
            return $this->render('AppBundle::emptycontent.html.twig'
            );
        }

        return $this->render('AppBundle::videos.html.twig',array(
            'videos' => $videos,'country'=>$countryName,'category'=>$categoryName,'subcategory'=>$subcategoryEntity));
    }

    /**
     * @Route("/youtube/{link}")
     *
     *
     */
    public function youtubeVideosAction($link)
    {
//        $link='https://www.youtube.com/watch?v='.$link;
        return $this->render('AppBundle::youtubeplayer.html.twig',array('link'=>$link));
    }
    /**
     * @Route("/play/{id}")
     * @Template()
     */
    public function playAction($id=1)
    {
        $video = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Video')
            ->find($id);

        if (!$video) {
            throw $this->createNotFoundException(
                'No video found for id '.$id
            );
        }
//        $path= $video;//->getVideoFile();//.mozFullPath;

        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($video, 'videoFile');


        //$path = "videos/sample.mp4";
        return $this->render('SiploMediaBundle::videoplayer.html.twig',array(
            'path' => $path));
    }


    /**
     * @Route("/upload/video")
     *
     */
    public function uploadAction(Request $request)
    {

        $form = $this->createForm(new VideoType(), new Video());
        $form->handleRequest($request);
        if ($form->isValid()) {


            $video = $form->getData();
            $user= $this->get('security.context')->getToken()->getUser();
            $video->setUser($user);

//            Following two lines are added to avoid the categoty and sub category fields being null.
//            If they are nullable Admin pannel will not suggest them
            $video->setCategory($this->getDoctrine()->getRepository('SiploMediaBundle:Category')->find(1));
            $video->setSubCategory($this->getDoctrine()->getRepository('SiploMediaBundle:SubCategory')->find(1));

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirect("/upload/video/categorize/".$video->getId());

        }

        return $this->render(
            '@SiploMedia/form.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route("/upload/video/categorize/{id}")
     *
     */
    public function upload2Action($id)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();
        $video = $em->getRepository('SiploMediaBundle:Video')->find($id);

        $form = $this->createForm(new VideoCategorizeType(), $video);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $video = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->render('SiploMediaBundle::upload_successful.html.twig');

        }

        return $this->render(
            '@SiploMedia/form.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route("/download/video/{id}")
     *
     */
    public function downloadAction($id)
    {

        $video = $this->getDoctrine()
            ->getRepository('SiploMediaBundle:Video')
            ->find($id);

        if (!$video) {
            throw $this->createNotFoundException(
                'No photo found for id '.$id
            );
        }


        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $this->get('kernel')->getRootDir(). "/../web/".$helper->asset($video, 'videoFile');
        $content = file_get_contents($path);

        $response = new Response();

//        $response->headers->set('Content-Type', '');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$video->getVideoName());

        $response->setContent($content);
        return $response;
    }
}
