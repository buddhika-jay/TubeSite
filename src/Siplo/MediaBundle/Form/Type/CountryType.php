<?php

namespace Siplo\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CountryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('code', 'text');
        $builder->add('backgroundImage', 'vich_file');
        $builder->add('flag', 'vich_file');
        $builder->add('categories', 'entity', array(
            'class' => 'SiploMediaBundle:Category',
            'choice_label' => 'title',
            'expanded'=>true,
            'multiple' => true,
        ));
        $builder->add('subCategories', 'entity', array(
            'class' => 'SiploMediaBundle:SubCategory',
            'choice_label' => 'title',
            'expanded'=>true,
            'multiple' => true,
        ));
        $builder->add('upload', 'submit');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siplo\MediaBundle\Entity\Country'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siplo_mediabundle_country';
    }
}
