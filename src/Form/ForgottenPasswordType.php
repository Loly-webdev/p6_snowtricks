<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * Class ForgottenPasswordType
 * @package App\Form
 */
class ForgottenPasswordType extends ApplicationType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                $this->fieldsConfiguration('Veuillez saisir une adresse email.')
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'translation_domain' => 'account-form',
            ]
        );
    }
}

