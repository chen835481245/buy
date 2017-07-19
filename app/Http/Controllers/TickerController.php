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
        $res = $this->apiTicker->cancelOrder(432066669);
        print_r($res);exit;

        $trade = $this->apiTicker->trade(260,1);
        print_r($trade);
        $res = $this->apiTicker->orderInfo($trade['order_id']);
        print_r($res);exit;

        print_r($trade);exit;
        $userInfo =$this->apiTicker->userInfo();
        print_r($userInfo);
        exit;
        $data = $this->apiTicker->kline('ltc_cny','1hour',20);
        print_r($data);exit;

        $data = $this->apiTicker->depth('ltc_cny');
        print_r($data);exit;
        echo 'index';
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resArr = $this->apiTicker->ticker('ltc_cny');
        $data = $resArr['ticker'];
        $data['date'] = $resArr['date'];
        $data['symbol'] = 'ltc_cny';
        $data['platform'] = 1;
        $this->ticker->create($data);
        print_r($data);
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
