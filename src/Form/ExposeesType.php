<?php
namespace App\Form;

use App\Entity\Exposees;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ExposeesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ide')
            ->add('nom_e')
            ->add('date_debut')
            ->add('date_fin')
            ->add('imageExposees',FileType::class, array('data_class' => null,'required' => false))
            ->add('produits_existants', IntegerType::class, [
                'label' => 'Produits',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exposees::class,
        ]);
    }
}
