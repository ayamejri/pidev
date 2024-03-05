<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;


class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom_user', TextType::class, [
            'label' => 'Nom',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer un nom.',
                ]),
                new Length([
                    'max' => 50,
                    'maxMessage' => 'Le nom ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('prenom_user', TextType::class, [
            'label' => 'Prénom',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer un prénom.',
                ]),
                new Length([
                    'max' => 50,
                    'maxMessage' => 'Le prénom ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('adresse_user', TextType::class, [
            'label' => 'Adresse',
            'required' => false,
            'constraints' => [
                new Length([
                    'max' => 50,
                    'maxMessage' => 'L\'adresse ne doit pas dépasser {{ limit }} caractères.',
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+\s+\d{4}$/',
                    'message' => 'L\'adresse doit contenir une chaîne de caractères suivie d\'un espace et d\'un code postal de 4 chiffres.',
                ]),
            ],
        ])
        
            
        
        
        
        ->add('tel_user', TelType::class, [
            'label' => 'Téléphone',
            'required' => false,
            'constraints' => [
                new Length([
                    'min' => 8,
                    'minMessage' => 'Le numéro de téléphone doit avoir au moins {{ limit }} chiffres.',
                    'max' => 8,
                    'maxMessage' => 'Le numéro de téléphone ne doit pas dépasser {{ limit }} chiffres.',
                ]),
                new Regex([
                    'pattern' => '/^\d+$/',
                    'message' => 'Le numéro de téléphone doit contenir uniquement des chiffres.',
                ]),
            ],
        ])
        ->add('email')
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'Vous devez accepter nos conditions.',
                ]),
            ],
        ]);
        
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
