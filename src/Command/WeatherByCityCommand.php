<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:by_city',
    description: 'Add a short description for your command',
)]
class WeatherByCityCommand extends Command
{
    public function __construct(
        private WeatherUtil $weatherUtil,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('city_name', InputArgument::REQUIRED, 'Name of the city')
            ->addArgument('country_code', InputArgument::REQUIRED, 'Country code of the city')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $city_name = $input->getArgument('city_name');
        $country_code = $input->getArgument('country_code');

        $forecasts = $this->weatherUtil->getWeatherforCountryAndCity($country_code, $city_name);
        $io->writeln('Weather for ' . $city_name . ', ' . $country_code);
        foreach ($forecasts as $forecast) {
            $io->writeln($forecast->getDate()->format('Y-m-d') . ' ' . $forecast->getTemperature());
        }

        return Command::SUCCESS;
    }
}
