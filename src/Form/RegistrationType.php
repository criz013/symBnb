<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'firstname',TextType::class, $this->getConfiguration( 'prenom','votre prenom' ) )
            ->add( 'lastname', TextType::class, $this->getConfiguration( "Prenom", "Votre prenom" ) )
            ->add( 'email', EmailType::class, $this->getConfiguration( "Email", "Votre e-mail" ) )
            ->add( 'picture', UrlType::class, $this->getConfiguration( "Votre photo de profils", "Url de votre avatar" ) )
            ->add( 'hash', PasswordType::class, $this->getConfiguration( 'Mot de passe', 'votre Mot de passe' ) )
            ->add( 'passwordConfirm', PasswordType::class, $this->getConfiguration( 'Confirmer votre Mdp', 'confirmer Mot de passe' ) )
            ->add( 'introduction', TextType::class, $this->getConfiguration( 'Introduction', 'Presentez vous en quelques mots' ) )
            ->add( 'description', TextareaType::class, $this->getConfiguration( 'Presentation', 'Presentez vous !' ) )
        ;
    }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver->setDefaults(
            [
                'data_class' => Users::class,
            ]
        );
    }
}
