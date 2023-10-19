<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\WeatherForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{name}', name: 'app_weather')] // id must be a number (\d+)
    public function city(Location $location, WeatherForecastRepository $repository): Response
    {
        $forecasts = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
//            'controller_name' => 'WeatherController',
        ]);
    }
}
