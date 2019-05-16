<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    private $transformer;

    public function __construct(FrenchToDateTimeTransformer $transformer){

        $this->transformer = $transformer;
    }

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'startDate', TextType::class, $this->getConfiguration( "Date d'arrivée", "La date à laquelle vous comptez arriver" ) )
            ->add( 'endDate',  TextType::class, $this->getConfiguration( "Date de départ", "La date à laquelle vous comptez partir" ) )
            ->add( 'comment', TextareaType::class, $this->getConfiguration( false, "Quelque chose a dire ?", ["required" => false]) );
            $builder->get('startDate')->setModelTransformer($this->transformer);
            $builder->get('endDate')->setModelTransformer($this->transformer);
        }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver->setDefaults( [
            'data_class' => Booking::class,
        ] );
    }
}
