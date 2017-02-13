<?php

namespace TracabiliteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use TracabiliteBundle\Form\PhotoType;

class TraceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //->add('date')
        ->add('date', DateType::Class, array(
                    'required'  => false,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr'=>array(
                        'placeholder'=>'dd/mm/yyyy',
                        'class'=>'datepicker form-control'
                    ),
        ))
        ->add('remarque')
        //->add('photos')
        ->add('photos', CollectionType::class, array(
            'entry_type'   => PhotoType::class,
            'entry_options'  => array(
                'attr'      => array('class' => 'email-box')
            ),
            'allow_add' => true,
            'allow_delete'=> true,
            'prototype' => true,
        ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TracabiliteBundle\Entity\Trace'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tracabilitebundle_trace';
    }


}
