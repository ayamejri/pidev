<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; // Import TextareaType
use Symfony\Component\Form\Extension\Core\Type\DateTimeType; // Import DateTimeType
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use App\Entity\Thread; 

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class, [ 
                'attr' => ['rows' => 8] // Adjust the number of rows to make the textarea bigger
            ])
            ->add('createdAt', DateTimeType::class, [ 
                'widget' => 'choice',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm:ss',
            ])
            ->add('author')
            ->add('thread', EntityType::class, [ 
                'class' => Thread::class, 
                'choice_label' => 'title', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
