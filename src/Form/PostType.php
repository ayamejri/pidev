<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use App\Entity\Thread; 

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('createdAt', DateTimeType::class, [ 
                'widget' => 'choice', // Render as a single input field
                'html5' => false, // Allow non-HTML5 browsers to fallback to a text input
                'format' => 'yyyy-MM-dd HH:mm:ss', // Date and time format
                // You can add more options like 'attr' to specify additional attributes for the input field if needed
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
