<?php
/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 9/15/15
 * Time: 7:50 PM
 */

namespace Siplo\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Siplo\MediaBundle\Entity\Country;
use Siplo\MediaBundle\Entity\Category;

class PhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('photo', 'vich_file');
        $builder->add('country', 'entity', array(
            'class' => 'SiploMediaBundle:Country',
            'choice_label' => 'name',
        ));
        $builder->add('category', 'entity', array(
            'class' => 'SiploMediaBundle:Category',
            'choice_label' => 'title',
        ));

        $formModifier = function (FormInterface $form, Country $country=null) {
            $categories = null === $country ? array() : $country->getCategories();
//            $categories = $country->getCategories();

            $form->add('category', 'entity', array(
                'class'       => 'SiploMediaBundle:Category',
                'placeholder' => '',
                'choices'     => $categories,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

//                $formModifier($event->getForm(), $data->getCountry());
                $formModifier($event->getForm(), $data->getCountry());
            }
        );

        $builder->get('photo')->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $photo = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $photo->getCountry());
            }
        );

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