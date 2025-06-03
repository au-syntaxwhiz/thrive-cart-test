<?php

declare(strict_types=1);

namespace ThriveCartAcme\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
use ThriveCartAcme\Service\BasketService;

class BasketCostCommand extends AbstractCommand
{
    private BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        parent::__construct();
        $this->basketService = $basketService;
    }

    protected function configure(): void
    {
        $this
            ->setName('basket:cost')
            ->setDescription('Calculate the cost of a basket')
            ->addArgument('products', InputArgument::REQUIRED, 'Comma-separated list of product codes');
    }

    protected function handle(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $products = explode(',', $input->getArgument('products'));

        $io->title('🛒 Basket Cost Calculator');
        $io->section('Products in Basket');

        $io->table(
            ['Code', 'Name', 'Price'],
            array_map(
                fn($code) => [
                    $code,
                    $this->getProductName($code),
                    '$' . number_format($this->getProductPrice($code), 2)
                ],
                $products
            )
        );

        $costs = $this->basketService->__invoke($products);

        $io->section('Cost Breakdown');
        $io->table(
            ['Item', 'Amount'],
            [
                ['Subtotal', '$' . number_format($costs['subtotal'], 2)],
                ['Discount', '-$' . number_format($costs['discount'], 2)],
                ['Delivery', '$' . number_format($costs['delivery'], 2)],
                ['<fg=green>Total</>', '<fg=green>$' . number_format($costs['total'], 2) . '</>']
            ]
        );

        return SymfonyCommand::SUCCESS;
    }

    private function getProductName(string $code): string
    {
        return match ($code) {
            'R01' => 'Red Widget',
            'G01' => 'Green Widget',
            'B01' => 'Blue Widget',
            default => 'Unknown Product'
        };
    }

    private function getProductPrice(string $code): float
    {
        return match ($code) {
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95,
            default => 0.00
        };
    }
}
