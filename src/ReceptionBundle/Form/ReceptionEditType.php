<?php

namespace ReceptionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use TracabiliteBundle\Form\PhotoType;

class ReceptionEditType extends AbstractType
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
                    ),
                ))
            ->add('degre')
            ->add('bonLivraison')
            ->add('remarque')
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReceptionBundle\Entity\Reception',
            //'validation_groups' => array("Default","new"),
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
