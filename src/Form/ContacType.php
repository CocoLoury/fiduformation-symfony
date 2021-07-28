<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContacType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de film',
                'attr' => [
                    'placeholder' => 'Veuillez mettre le nom du film'
                ],
                'required' => false
            ])
            ->add('description', TextareaType::class)
            ->add('telephone', TelType::class)
            ->add('email', EmailType::class)
            ->add('liste', ChoiceType::class, [
                'choices' => [
                    'aaa' => 'aa',
                    'bbb' => 'bb',
                    'aaaa' => 'aaa',
                    'bbbb' => 'bbb'
                ],
                'expanded' => false,
                'multiple' => true
            ])
            ->add('enregistrer', SubmitType::class)
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
