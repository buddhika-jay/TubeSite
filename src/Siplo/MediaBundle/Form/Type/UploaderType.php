<?php
namespace Siplo\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class UploaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('video', new VideoType());
//        $builder->add(
//            'terms',
//            'checkbox',
//            array('property_path' => 'termsAccepted')
//        );
        $builder->add('Upload', 'submit');
    }

    public function getName()
    {
        return 'Upload';
    }
}