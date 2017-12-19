<?php

namespace AdminBundle\Form;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNais',BirthdayType::class,array('placeholder' => array(
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour') ))
            ->add('adress')
            ->add('codePostal',IntegerType::class)
            ->add('ville')
            ->add('tel',IntegerType::class);
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Personne'
        ));
    }
    public function  getName()
    {
        return 'Admin_registration';
    }
}

