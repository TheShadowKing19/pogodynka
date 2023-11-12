<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\WeatherForecastRepository;
use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/forecast/{name}/{city}', name: 'app_weather')] // id must be a number (\d+)
    public function city(
        #[MapEntity(mapping: ['name' => 'name', 'city' => 'country_code'])]
        Location $location,
        WeatherUtil $util): Response
    {
        $forecasts = $util->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
//            'controller_name' => 'WeatherController',
        ]);
    }
}
