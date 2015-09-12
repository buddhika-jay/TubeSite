<?php
namespace Siplo\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class CategoryUploaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', new CategoryType());
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