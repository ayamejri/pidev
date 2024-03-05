<?php

namespace App\Form;

use App\Entity\Thread;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; // Import TextareaType

class ThreadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('topic', TextareaType::class, [ 
                'attr' => ['rows' => 8] // Adjust the number of rows to make the textarea bigger
            ])
            ->add('createdat')
            ->add('author')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Thread::class,
        ]);
    }
}
