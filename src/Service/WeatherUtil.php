<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\WeatherForecast;
use App\Repository\LocationRepository;
use App\Repository\WeatherForecastRepository;

class WeatherUtil
{
    public function __construct(
        private WeatherForecastRepository $weatherForecastRepository,
        private LocationRepository        $locationRepository,
    )
    {

    }

    /**
     * @return WeatherForecast[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        $forecasts = $this->weatherForecastRepository->findByLocation($location);
        return $forecasts;
    }

    /**
     * @return WeatherForecast[]
     */
    public function getWeatherforCountryAndCity(string $countryCode, string $city): array
    {
//        get weather forecast for city and country
        $location = $this->locationRepository->findOneBy(['name' => $city, 'country_code' => $countryCode]);
        return $this->getWeatherForLocation($location);

    }
}