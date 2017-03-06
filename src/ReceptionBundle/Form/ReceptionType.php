<?php

namespace ReceptionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use TracabiliteBundle\Form\PhotoType;

class ReceptionType extends AbstractType
{

    /*private $validationGroups;

    public function __construct()
    {
        $this->validationGroups[] = "Default";
        $this->validationGroups[] = 'new';
    }*/

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
                    ),
                ))
            ->add('degre')
            ->add('bonLivraison')
            ->add('remarque')
            ->add('photos', CollectionType::class, array(
                'entry_type'   => PhotoType::class,
                'entry_options'  => array(
                    'attr'      => array('class' => 'photos-box')
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
            'data_class' => 'ReceptionBundle\Entity\Reception',
            'validation_groups' => array("Default","new"),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'receptionbundle_reception';
    }


}
