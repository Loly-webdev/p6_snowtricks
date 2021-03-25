<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Class RegistrationType
 * @package App\Form
 */
class RegistrationType extends ApplicationType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        $builder
            ->add('username', TextType::class, $this->fieldsConfiguration('Votre pseudo.'))
            ->add('email', EmailType::class, $this->fieldsConfiguration('Votre adresse email.'))
            ->add('password', PasswordType::class, $this->fieldsConfiguration('Votre mot de passe.'))
            ->add('passwordVerification', PasswordType::class, $this->fieldsConfiguration('Confirmer le mot de passe.'))
            ->add('profile_picture', FileType::class, [
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class'         => User::class,
                                   'translation_domain' => 'account-form'
                               ]);
    }
}
