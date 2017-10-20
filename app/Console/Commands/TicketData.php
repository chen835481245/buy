<?php

namespace App\Console\Commands;


use App\Model\OkCoinApi;
use App\Ticker;
use Illuminate\Console\Command;

class TicketData extends Command
{

    protected $ticker;
    protected $apiTicker;

    /**
     * TicketData constructor.
     * @param Ticker $ticker
     * @param OkCoinApi $apiTicker
     */
    public function __construct(Ticker $ticker, OkCoinApi $apiTicker)
    {
        $this->ticker = $ticker;
        $this->apiTicker = $apiTicker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $resArr = $this->apiTicker->ticker('ltc_cny');
        $data = $resArr['ticker'];
        $data['date'] = $resArr['date'];
        $data['symbol'] = 'ltc_cny';
        $data['platform'] = 1;
        $this->ticker->create($data);
    }
}
