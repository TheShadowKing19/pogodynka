<?php

namespace App\Tests\Entity;

use App\Entity\WeatherForecast;
use PHPUnit\Framework\TestCase;

class WeatherForecastTest extends TestCase
{
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $weatherForecast = new WeatherForecast();
        $weatherForecast->setTemperature($celsius);

        $this->assertEquals($expectedFahrenheit, $weatherForecast->getFahrenheit());

    }

    public function dataGetFahrenheit(): array
    {
        return [
            [0, 32],
            [-100, -148],
            [100, 212],
            [0.5, 32.9],
            [-0.5, 31.1],
            [11, 51.8],
            [-11, 12.2],
            [21.5, 70.7],
            [16.22, 61.196],
            [-6, 21.2],
        ];
    }
}
