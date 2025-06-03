# ThriveCart ACME Project

## CLI Commands

The project includes a command-line interface (CLI) built with Symfony Console. The main entry point is located in the `bin` directory.

### Bin Directory

The `bin` directory contains the executable script `thrive-cart`, which is the main entry point for all CLI commands. This script is registered in `composer.json` under the `bin` section, allowing you to run commands globally if installed via Composer.

### Usage

To run a command, use:

```bash
php bin/thrive-cart <command>
```

For example, to run the `hello` command:

```bash
php bin/thrive-cart hello
```

### Available Commands

- **hello**: Displays a greeting message.

### Adding New Commands

To add a new command, create a new class in `src/Console/Command` that extends `AbstractCommand` and implement the required methods. Then, register the command in `bin/thrive-cart`.

Example:

```php
<?php

declare(strict_types=1);

namespace ThriveCartAcme\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewCommand extends AbstractCommand
{
    protected function configure(): void
    {
        $this
            ->setName('new')
            ->setDescription('Description of the new command')
            ->setHelp('Help text for the new command');
    }

    protected function handle(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>New command executed!</info>');
        return SymfonyCommand::SUCCESS;
    }
}
```

Then, in `bin/thrive-cart`, add:

```php
$application->add(new NewCommand());
```