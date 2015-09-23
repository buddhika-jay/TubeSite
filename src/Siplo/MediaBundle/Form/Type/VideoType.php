<?php
namespace Siplo\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('country', 'entity', array(
            'class' => 'SiploMediaBundle:Country',
            'choice_label' => 'name',
            'read_only' => 'true,',
        ));
        $builder->add('VideoTitle', 'text');
        $builder->add('videoFile', 'vich_file',array('required'    => false));
        $builder->add('youtubeLink', 'text',array('required'    => false));
        $builder->add('thumbnail', 'vich_file');
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siplo\MediaBundle\Entity\Video'
        ));
    }

    public function getName()
    {
        return 'siplo_mediabundle_video';
    }
}