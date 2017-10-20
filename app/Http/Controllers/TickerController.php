<?php

namespace App\Http\Controllers;

use App\Ticker;
use Illuminate\Http\Request;
use App\Model\OkCoinApi;

class TickerController extends Controller
{
    protected $ticker;
    protected $apiTicker;

    public function __construct(Ticker $ticker,OkCoinApi $apiTicker)
    {
        $this->ticker = $ticker;
        $this->apiTicker = $apiTicker;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        set_time_limit(0);
        while(true){
            echo time();
            $resArr = $this->apiTicker->ticker('ltc_cny');
            $data = $resArr['ticker'];
            $data['date'] = $resArr['date'];
            $data['symbol'] = 'ltc_cny';
            $data['platform'] = 1;
            $this->ticker->create($data);
            sleep(5);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\Response
     */
    public function show(Ticker $ticker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticker $ticker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticker $ticker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticker $ticker)
    {
        //
    }
}
