<?php

namespace App\Console\Commands;

use App\Models\Currency;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchCurrenciesCommand extends Command
{
    protected $signature = 'currencies:fetch';
    protected $description = 'Fetches and updates currency rates';

    private const VALID_CURRENCIES = [
        'EUR',
        'USD',
        'RUB',
        'GBP',
    ];
    private const BASE_CURRENCY = 'USD';

    private Client $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client();
    }

    public function handle(): int
    {
        $url = sprintf('https://api.coinbase.com/v2/exchange-rates?currency=%s', self::BASE_CURRENCY);
        try {
            $response = $this->client->get($url);

            if ($response->getStatusCode() !== 200) {
                Log::error('Failed to fetch currencies', [
                    'status' => $response->getStatusCode(),
                    'response' => $response->getBody()->getContents()
                ]);

                $this->error('Failed to fetch currency rates. Status Code: ' . $response->getStatusCode());

                return 1;
            }

            $currencyData = json_decode($response->getBody()->getContents());
            foreach ($currencyData->data->rates as $symbol => $rate) {
                if (false === in_array($symbol, $this::VALID_CURRENCIES)) {
                    continue;
                }

                Currency::updateOrCreate([
                    'symbol' => $symbol,
                ], [
                    'rate' => $rate,
                ]);
            }

            $this->info('Currency rates updated successfully.');
        } catch (\Exception $e) {
            Log::error('Exception when fetching currencies', ['exception' => $e->getMessage()]);
            $this->error('An error occurred: ' . $e->getMessage());

            return 1;
        }

        return 0;
    }

}
