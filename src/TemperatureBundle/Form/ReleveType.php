<?php

namespace TemperatureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use TemperatureBundle\Form\DegreType;

class ReleveType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', DateType::Class, array(
                    'required'  => true,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr'=>array(
                        'placeholder'=>'dd/mm/yyyy',
                        'class'=>'datepicker form-control'
                    ),))
                /*->add('moment', ChoiceType::class, array(
                        'choices' => array(
                            'matin' => 'matin',
                            'soir' => 'soir'
                        ),
                        'expanded'=>true,
                    ))*/
                ->add('degres', CollectionType::class, array(
                    'entry_type'   => DegreType::class,
                    'entry_options'  => array(
                        'attr'      => array('class' => 'degre-box')
                    ),
                    'allow_add' => true,
                    'allow_delete'=> true,
                    'prototype' => true,
                    'by_reference' => false,
                ))



                ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TemperatureBundle\Entity\Releve'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'temperaturebundle_releve';
    }


}
