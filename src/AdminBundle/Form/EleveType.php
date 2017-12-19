<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class EleveType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomPere')
            ->add('nomMere')
            ->add('fonctionPere')
            ->add('fonctionMere')
            ->add('telParent1',IntegerType::class)
            ->add('telParent2',IntegerType::class)
            ->add('lieuNaisance')
            ->add('arrivede')
            ->add('nivPrec')
            ->add('nom')
            ->add('prenom')
            ->add('dateNais',BirthdayType::class,array('placeholder' => array(
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour') ))
            ->add('adress')
            ->add('codePostal',IntegerType::class)
            ->add('ville')
            ->add('adress_parent')
            ->add('sexe', ChoiceType::class, array('choices'  => array(
                    'Choisir le sexe'=>null,
                    'Garçon' =>'Homme' ,
                    'Fille'=>'femme',
                )))
            ->add('tel',IntegerType::class)
            ->add('file',FileType::class,array('label'=>'Ajouter une photo'))
            ->remove('dateentre')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Eleve'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_eleve';
    }


}
