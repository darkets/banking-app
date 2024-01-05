<?php

namespace App\Console\Commands;

use App\Models\Crypto;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchCryptoCommand extends Command
{
    protected $signature = 'crypto:fetch';
    protected $description = 'Fetch current crypto rates';

    private const CRYPTO = ['BTC', 'ETH', 'BNB', 'USDT'];

    private Client $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client();
    }

    public function handle(): int
    {
        foreach (self::CRYPTO as $crypto) {
            $response = $this->client->get("https://api.coinbase.com/v2/exchange-rates?currency={$crypto}");
            $data = json_decode($response->getBody(), true);

            if (empty($data['data']['rates'])) {
                $this->error("Failed to fetch rates for {$crypto}");
                continue;
            }

            $rates = $data['data']['rates'];
            $usdRate = $rates['USD'] ?? null;
            $eurRate = $rates['EUR'] ?? null;
            $rubRate = round($rates['RUB'], 2) ?? null;
            $gbpRate = $rates['GBP'] ?? null;

            if ($usdRate && $eurRate && $rubRate && $gbpRate) {
                Crypto::updateOrCreate(
                    ['crypto_symbol' => $crypto],
                    ['USD' => $usdRate, 'EUR' => $eurRate, 'RUB' => $rubRate, 'GBP' => $gbpRate]
                );
            } else {
                $this->error("Could not fetch values for {$crypto}");
            }
        }

        $this->info('Crypto rates updated successfully.');
        return 0;
    }
}
