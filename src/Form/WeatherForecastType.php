<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\WeatherForecast;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeatherForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('wind_speed')
            ->add('cloudiness')
            ->add('temperature')
            ->add('air_quality')
            ->add('humidity')
            ->add('pressure')
            ->add('date')
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WeatherForecast::class,
        ]);
    }
}
