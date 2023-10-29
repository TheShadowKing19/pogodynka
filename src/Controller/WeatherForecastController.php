<?php

namespace App\Controller;

use App\Entity\WeatherForecast;
use App\Form\WeatherForecastType;
use App\Repository\WeatherForecastRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/weather/forecast')]
class WeatherForecastController extends AbstractController
{
    #[Route('/', name: 'app_weather_forecast_index', methods: ['GET'])]
    public function index(WeatherForecastRepository $weatherForecastRepository): Response
    {
        return $this->render('weather_forecast/index.html.twig', [
            'weather_forecasts' => $weatherForecastRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_weather_forecast_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $weatherForecast = new WeatherForecast();
        $form = $this->createForm(WeatherForecastType::class, $weatherForecast, [
            'validation_groups' => 'create',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($weatherForecast);
            $entityManager->flush();

            return $this->redirectToRoute('app_weather_forecast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weather_forecast/new.html.twig', [
            'weather_forecast' => $weatherForecast,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_forecast_show', methods: ['GET'])]
    public function show(WeatherForecast $weatherForecast): Response
    {
        return $this->render('weather_forecast/show.html.twig', [
            'weather_forecast' => $weatherForecast,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_weather_forecast_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WeatherForecast $weatherForecast, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WeatherForecastType::class, $weatherForecast, [
            'validation_groups' => 'edit',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_weather_forecast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weather_forecast/edit.html.twig', [
            'weather_forecast' => $weatherForecast,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_forecast_delete', methods: ['POST'])]
    public function delete(Request $request, WeatherForecast $weatherForecast, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weatherForecast->getId(), $request->request->get('_token'))) {
            $entityManager->remove($weatherForecast);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_weather_forecast_index', [], Response::HTTP_SEE_OTHER);
    }
}
