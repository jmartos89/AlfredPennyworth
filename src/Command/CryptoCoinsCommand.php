<?php

namespace App\Command;

use App\Service\CryptoCoinsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CryptoCoinsCommand extends Command
{
    /** @var CryptoCoinsService $cryptoCoinsService */
    protected $cryptoCoinsService;

    public function __construct(CryptoCoinsService $cryptoCoinsService, $name = null)
    {
        parent::__construct($name);

        $this->cryptoCoinsService = $cryptoCoinsService;
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('ap:crypto-coins')

            // the short description shown while running "php bin/console list"
            ->setDescription('Get cryptocoins info.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cryptoCoins = $this->cryptoCoinsService->getCryptoCoins();

        $data = $this->getData();

        foreach ($data as $d) {
            $key = array_search($d['crypto_coin'], array_column($cryptoCoins, 'id'));

            $cryptoCoin = $cryptoCoins[$key];

            $actual = $d['amount'] * $cryptoCoin['price_usd'];
            $difference = $actual - $d['invested'];

            $msg = sprintf('%s: %s $%s', $d['crypto_coin'], round($cryptoCoin['price_usd'], 2), PHP_EOL);
            $msg .= sprintf('Invested: %s $%s', round($d['invested'], 2), PHP_EOL);
            $msg .= sprintf('Amount: %s $%s', round($d['amount'], 5), PHP_EOL);
            $msg .= sprintf('Actual: %s $%s', round($actual, 2), PHP_EOL);
            $msg .= sprintf('+/-: %s $%s', round($difference, 2), PHP_EOL);
            $msg .= sprintf('------------------------------------%s', PHP_EOL);

            $output->writeln($msg);
        }
    }

    private function getData()
    {
        return [
            [
                'crypto_coin' => 'bitcoin',
                'amount' => '0.08527',
                'invested' => '388.19000'
            ],
            [
                'crypto_coin' => 'ethereum',
                'amount' => '0.53303',
                'invested' => '149.30000'
            ],
            [
                'crypto_coin' => 'iota',
                'amount' => '247.00000',
                'invested' => '717.87000'
            ],
            [
                'crypto_coin' => 'litecoin',
                'amount' => '5.00000',
                'invested' => '241.68000'
            ],
            [
                'crypto_coin' => 'ripple',
                'amount' => '998.44450',
                'invested' => '239.29000'
            ],
            [
                'crypto_coin' => 'neo',
                'amount' => '2.50000',
                'invested' => '119.65000'
            ]
        ];
    }
}
