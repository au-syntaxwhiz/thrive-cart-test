<?php

declare(strict_types=1);

namespace ThriveCartAcme\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class BasketCostCommand extends AbstractCommand
{
    protected function configure(): void
    {
        $this
            ->setName('basket:cost')
            ->setDescription('Calculate the cost of a basket')
            ->addArgument('products', InputArgument::REQUIRED, 'Comma-separated list of product codes');
    }

    protected function handle(InputInterface $input, OutputInterface $output): int
    {
        return SymfonyCommand::SUCCESS;
    }
}
