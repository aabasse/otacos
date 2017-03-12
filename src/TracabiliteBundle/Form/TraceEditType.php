<?php

namespace TracabiliteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use TracabiliteBundle\Form\PhotoType;

class TraceEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date', DateType::Class, array(
                    'required'  => true,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr'=>array(
                        'placeholder'=>'dd/mm/yyyy',
                        'class'=>'datepicker form-control'
                    ),
        ))
        ->add('remarque')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TracabiliteBundle\Entity\Trace',
            'validation_groups' => array("Default","edit"),
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
