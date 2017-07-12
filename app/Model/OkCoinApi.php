<?php
namespace App\Model;

use Curl\Curl;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: ch
 * Date: 2017/7/11
 * Time: 下午1:17
 */
class OkCoinApi
{
    const URL_TICKER = "https://www.okcoin.cn/api/v1/ticker.do";

    /**
     * @param string $symbol btc_cny,ltc_cny,eth_cny
     * @return mixed
     */
    public function ticker($symbol = 'btc_cny' ,$platform =1)
    {
        $curl = new Curl();
        $res = $curl->get(self::URL_TICKER, ['symbol' => $symbol]);
        return $res;
    }

}