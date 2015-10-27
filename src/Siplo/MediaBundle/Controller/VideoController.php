<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Siplo\MediaBundle\Form\Type\VideoType;
use Siplo\MediaBundle\Form\Type\VideoCountrySelectType;
use Siplo\MediaBundle\Entity\Video;

class VideoController extends Controller
{
    /**
     * @Route("/{country}/{category}/videos/{subcategory}",requirements={
     *     "country": "(?<![-.])\b[0-9]+\b(?!\.[0-9])","category":"(?<![-.])\b[0-9]+\b(?!\.[0-9])","subcategory":"(?<![-.])\b[0-9]+\b(?!\.[0-9])"
     * }))
     *
     */
    public function showVideosAction($country,$category,$subcategory)
    {

        //        find country id
        $countryEntiy=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:Country')->findOneById($country);
        $countryID=$countryEntiy->getId();
        $countryName=$countryEntiy->getName();


//        find categroy id
        $categoryEntity=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:Category')->findOneById($category);
        $categoryID=$categoryEntity->getId();

        $categoryName=$categoryEntity->getTitle();
//        get subcategory entity
        $subcategoryEntity=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:SubCategory')->findOneById($subcategory);
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
//            App:videos requires a video id to play by default. Id of the first video is sent to it
            'videos' => $videos,'country'=>$countryName,'category'=>$categoryName,'subcategory'=>$subcategoryEntity, 'videoId'=>2));
    }

    /**
     * @Route("/{country}/{category}/videos/{subcategory}/{videoId}",requirements={
     *     "country": "(?<![-.])\b[0-9]+\b(?!\.[0-9])","category":"(?<![-.])\b[0-9]+\b(?!\.[0-9])","subcategory":"(?<![-.])\b[0-9]+\b(?!\.[0-9])"
     * }))
     *
     */
    public function playByUrlAction($country,$category,$subcategory, $videoId)
    {
//        This Action is used to play a video when it get shared on facebook.

        //        find country id
        $countryEntiy=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:Country')->findOneById($country);
        $countryID=$countryEntiy->getId();
        $countryName=$countryEntiy->getName();


//        find categroy id
        $categoryEntity=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:Category')->findOneById($category);
        $categoryID=$categoryEntity->getId();

        $categoryName=$categoryEntity->getTitle();
//        get subcategory entity
        $subcategoryEntity=$this->getDoctrine()
            ->getRepository('SiploMediaBundle:SubCategory')->findOneById($subcategory);
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
            'videos' => $videos,'country'=>$countryName,'category'=>$categoryName,'subcategory'=>$subcategoryEntity, 'videoId'=>$videoId));
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

        $form = $this->createForm(new VideoCountrySelectType(), new Video());
        $form->handleRequest($request);
        if ($form->isValid()) {

            $video = $form->getData();
            return $this->redirect("/upload/video/".$video->getCountry()->getId());

        }

        return $this->render(
            '@SiploMedia/form.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route("/upload/video/{countryId}")
     *
     */
    public function upload2Action($countryId)
    {
        $request = $this->get('request');
        //get selected country in previeouse form and set it in video object
        $em = $this->getDoctrine()->getEntityManager();
        $country = $em->getRepository('SiploMediaBundle:Country')->find($countryId);

        $video = new Video();
        $video->setCountry($country);

        $form = $this->createForm(new VideoType(), $video);
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
