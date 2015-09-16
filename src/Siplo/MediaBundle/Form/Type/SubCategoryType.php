<?php

namespace Siplo\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text');
        $builder->add('code', 'text');
        $builder->add('description', 'text');
        $builder->add('backgroundImage', 'vich_file');

        $builder->add('country', 'entity', array(
            'class' => 'SiploMediaBundle:Country',
            'choice_label' => 'name',
        ));
        $builder->add('category', 'entity', array(
            'class' => 'SiploMediaBundle:Category',
            'choice_label' => 'title',
        ));

        $builder->add('upload', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siplo\MediaBundle\Entity\SubCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siplo_mediabundle_sub_category';
    }
}
