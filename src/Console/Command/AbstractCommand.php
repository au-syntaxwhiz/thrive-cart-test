<?php

declare(strict_types=1);

namespace ThriveCartAcme\Console\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends SymfonyCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            return $this->handle($input, $output);
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return SymfonyCommand::FAILURE;
        }
    }

    abstract protected function handle(InputInterface $input, OutputInterface $output): int;
}
