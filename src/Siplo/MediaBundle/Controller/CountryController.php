<?php

namespace Siplo\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Siplo\MediaBundle\Form\Type\CountryUploaderType;
use Siplo\MediaBundle\Form\Model\CountryUpload;

class CountryController extends Controller
{


    /**
     * @Route("/country/create")
     *
     */
    public function createCountryAction()
    {
        $uploader = new CountryUpload();
        $form = $this->createForm(new CountryUploaderType(), $uploader, array(
            'action' => '/country/create/save',
        ));

        return $this->render(
            'SiploMediaBundle::form.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Route("/country/create/save")
     *
     */
    public function countrySaveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new CountryUploaderType(), new CountryUpload());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $uploader = $form->getData();

            $em->persist($uploader->getCountry());
            $em->flush();

            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($uploader->getCountry(), 'backgroundImage');
//            return $this->redirectToRoute('play');
            return $this->render('SiploMediaBundle::videoplayer.html.twig',array(
                'path' => $path));
        }

        return $this->render(
            'SiploMediaBundle::form.html.twig',
            array('form' => $form->createView())
        );
    }
}
