<?php

namespace App\Form;

use App\Entity\Forecast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
            ])
            ->add('temperature', IntegerType::class, [
                'label' => 'Temperature (°C)',
                'attr' => [
                    'min' => -80,
                    'max' => 60,
                ],
            ])
            ->add('precipitation', IntegerType::class, [
                'label' => 'Precipitation (mm)',
                'attr' => [
                    'min' => 0,
                    'max' => 1000,
                ],
            ])
            ->add('pressure', IntegerType::class, [
                'label' => 'Pressure (hPa)',
                'attr' => [
                    'min' => 800,
                    'max' => 1200,
                ],
            ])
            ->add('condition', ChoiceType::class, [
                'label' => 'Weather condition',
                'choices' => [
                    'Sunny' => 'Sunny',
                    'Cloudy' => 'Cloudy',
                    'Rain' => 'Rain',
                    'Snow' => 'Snow',
                    'Storm' => 'Storm',
                ],
                'placeholder' => 'Choose a condition',
            ])
            ->add('windSpeed', IntegerType::class, [
                'label' => 'Wind speed (km/h)',
                'attr' => [
                    'min' => 0,
                ],
            ])
            ->add('humidity', IntegerType::class, [
                'label' => 'Humidity (%)',
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => static function (Location $location): string {
                    return sprintf(
                        '%s (%s)',
                        $location->getCity(),
                        $location->getCountry()
                    );
                },
                'placeholder' => 'Choose a location',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
