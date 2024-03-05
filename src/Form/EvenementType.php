<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Publicite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageEvenement',FileType::class, array('data_class' => null,'required' => false))
            ->add('themeEvenement')
            ->add('typeEvenement')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('nbrParticipant')
            ->add('Color',ColorType::class)
            ->add('Publicite',EntityType::class,['class' => Publicite::class,
            'choice_label' => 'sponsor',
            'label'=> 'Nom Sponsor' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
