<?php

namespace App\Form;

use App\Entity\Picture;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class PictureType
 * @package App\Form
 */
class PictureType extends ApplicationType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        unset($options);
        $builder
            ->add(
                'file',
                FileType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'caption',
                TextType::class,
                $this->fieldsConfiguration("Titre de l'image")
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class'         => Picture::class,
                'translation_domain' => 'picture-form',
            ]
        );
    }
}
