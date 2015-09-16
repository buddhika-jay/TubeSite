<?php
/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 9/15/15
 * Time: 7:50 PM

 */
//this formtype is a the step two of photo submission
namespace Siplo\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Siplo\MediaBundle\Entity\Country;
use Siplo\MediaBundle\Entity\Category;

class PhotoCategorizeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('category', 'entity', array(
            'class' => 'SiploMediaBundle:Category',
            'choices' => $builder->getData()->getCountry()->getCategories(),
            'required' => 'true',
        ));
        $builder->add('subCategory', 'entity', array(
            'class' => 'SiploMediaBundle:SubCategory',
            'choices' => $builder->getData()->getCountry()->getSubCategories(),
            'required' => 'true',
        ));


        $builder->add('upload', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siplo\MediaBundle\Entity\Photo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siplo_mediabundle_photo';
    }
}