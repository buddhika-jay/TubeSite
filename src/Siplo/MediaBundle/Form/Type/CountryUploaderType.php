<?php
namespace Siplo\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class CountryUploaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('country', new CountryType());
//        $builder->add(
//            'terms',
//            'checkbox',
//            array('property_path' => 'termsAccepted')
//        );
        $builder->add('upload', 'submit');
    }

    public function getName()
    {
        return 'Upload';
    }
}