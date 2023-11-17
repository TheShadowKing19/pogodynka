<?php

namespace App\Controller;

use App\Entity\WeatherForecast;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil $util,
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,

    ): JsonResponse | Response
    {

        $forecasts = $util->getWeatherforCountryAndCity($country, $city);
        switch ($format) {
            case 'json':
                if ($twig):
                    return $this->render('weather_api/index.json.twig', [
                        'data' => $this->json(
                            [
                                'city' => $city,
                                'country' => $country,
                                'forecasts' => array_map(fn(WeatherForecast $f) => [
                                    'date' => $f->getDate()->format('Y-m-d'),
                                    'celsius' => $f->getTemperature(),
                                ], $forecasts),
                            ]
                        ),
                    ]);
                else:
                    return $this->json([
                        'city' => $city,
                        'country' => $country,
                        'forecasts' => array_map(fn(WeatherForecast $f) => [
                            'date' => $f->getDate()->format('Y-m-d'),
                            'celsius' => $f->getTemperature(),
                        ], $forecasts),
                    ]);
                    break;
                endif;
            case 'csv':
                if ($twig):
                    return $this->render('weather_api/index.csv.twig', [
                        'city' => $city,
                        'country' => $country,
                        'forecasts' => $forecasts,
                    ]);
                else:
                    $response = new Response();
                    $response->headers->set('Content-Type', 'text/csv');
                    $response->headers->set('Content-Disposition', 'attachment; filename="weather.csv"');
                    $response->setContent("city,country,date,celsius\n" .
                        implode("\n", array_map(fn(WeatherForecast $f) => sprintf(
                            '%s,%s,%s,%d',
                            $city,
                            $country,
                            $f->getDate()->format('Y-m-d')
                            ,$f->getTemperature()
                        ), $forecasts)));
                    return $response;
                    break;
                endif;

        }
        return $this->json([
            'city' => $city,
            'country' => $country,
            'forecasts' => array_map(fn(WeatherForecast $f) => [
                'date' => $f->getDate()->format('Y-m-d'),
                'celsius' => $f->getTemperature(),
            ], $forecasts),
        ]);
    }
}
