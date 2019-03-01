<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AnnonceType
 * @package App\Form
 */
class AnnonceType extends AbstractType
{

    /**
     * Configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholder
     *
     * @return array
     */
    public function getConfiguration($label, $placeholder, $option =[]){
        return array_merge([
                    'label'=>$label,
                    'attr'=> [ 'placeholder' => $placeholder ]
                ], $option);
    }

    /**
     * Formulaire d'une nouvelle annonce
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre","Tapez un titre pour votre annonce."))
            ->add('slug', TextType::class,$this->getConfiguration("Adresse Web","Tapez l'adresse web (Automatique).",['required'=>false ]))
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image principal","L'image principal de votre annonce"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction","Donner une description global de l'annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Description detaillee","Donner une description qui donne envis"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambres","Le nombre de chambre disponiblephp"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit","Donner un prix pour une nuit"))
            ->add('images',CollectionType::class, ['entry_type' => ImageType::class,'allow_add'=>true,'allow_delete'=>true])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
