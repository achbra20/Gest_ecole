<?php

namespace AdminBundle\Form;

use AdminBundle\Entity\Niveau;
use AdminBundle\Entity\paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PayerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('montant')
            ->remove('datePayer')
            ->add('Paiment', EntityType::class,array('class'=>'AdminBundle:paiement','choice_label' =>'libelle','multiple'=>false))
            ->remove('Eleve')
            ->remove('Annee', EntityType::class,array('class'=>'AdminBundle:Annee','choice_label' =>'libelle','multiple'=>false))  ;


    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Payer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_payer';
    }


}
