<?php

namespace UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Services\AppService;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class UtilisateurEditType extends AbstractType
{
    private $appService;
    private $authorizationchecker;

    public function __construct(AuthorizationChecker $authorizationchecker, AppService $appService)
    {
        $this->authorizationchecker = $authorizationchecker;
        $this->appService = $appService;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $utilisateur = $builder->getData();
        $dataRoles = $utilisateur->getRoles();

        if ($this->authorizationchecker->isGranted('ROLE_ADMIN')) {
            $builder->add('entreprise')
            ->add('lesRoles', ChoiceType::Class, array(
                'choices'=>$this->appService->getRoles(),
                'multiple'=>true,
                'data' => $dataRoles,
            ));
        }
        $builder->remove('plainPassword');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UtilisateurBundle\Entity\Utilisateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'utilisateurbundle_utilisateur';
    }


}
