<?php

namespace App\Form;

<<<<<<<< HEAD:src/Form/PubliciteType.php
use App\Entity\Publicite;
========
use App\Entity\Comment;
>>>>>>>> origin/oussama_blog:src/Form/CommentType.php
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

<<<<<<<< HEAD:src/Form/PubliciteType.php
class PubliciteType extends AbstractType
========
class CommentType extends AbstractType
>>>>>>>> origin/oussama_blog:src/Form/CommentType.php
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<<< HEAD:src/Form/PubliciteType.php
            ->add('description')
            ->add('type')
            ->add('sponsor')
========
            ->add('content')
            ->add('author')
            ->add('createdAT')
            ->add('post')
>>>>>>>> origin/oussama_blog:src/Form/CommentType.php
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
<<<<<<<< HEAD:src/Form/PubliciteType.php
            'data_class' => Publicite::class,
========
            'data_class' => Comment::class,
>>>>>>>> origin/oussama_blog:src/Form/CommentType.php
        ]);
    }
}
