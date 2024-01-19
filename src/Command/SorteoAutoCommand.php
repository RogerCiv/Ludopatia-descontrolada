<?php

namespace App\Command;

use App\Entity\Sorteo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'SorteoAuto',
    description: 'Add a short description for your command',
)]
class SorteoAutoCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityManager = $this->getDoctrine()->getManager();
        $sorteoRepository = $this->getDoctrine()->getRepository(Sorteo::class);

        // Obtén los sorteos que cumplen la condición
        $sorteos = $sorteoRepository->findSorteosParaAutoSorteo();

        foreach ($sorteos as $sorteo) {
            // Realiza el sorteo automático
            $this->realizarSorteoAutomatico($sorteo, $entityManager);
        }

        $output->writeln('Sorteos automáticos realizados con éxito.');

        return Command::SUCCESS;
    }

    // Nueva función para realizar el sorteo automáticamente
    private function realizarSorteoAutomatico(Sorteo $sorteo, EntityManagerInterface $entityManager): void
    {
        // Verifica si el sorteo ya ha sido realizado
        if ($sorteo->getState() == 0) {
            // Verifica si la fecha actual supera la fecha de finalización del sorteo
            $fechaActual = new \DateTime();
            if ($fechaActual >= $sorteo->getFechaFin()) {
                $numerosLoteria = $sorteo->getNumerosLoteria();

                // Usar array_rand directamente en el array
                $numeroGanador = $numerosLoteria[array_rand($numerosLoteria)]->getNumero();

                // Establecer el número ganador en el sorteo
                $sorteo->setWinner($numeroGanador);

                // Actualizar el estado del sorteo
                $sorteo->setState(1);

                // Guardar los cambios en la base de datos
                $entityManager->flush();
            }
        }
    }

}
