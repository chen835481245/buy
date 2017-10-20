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
    const URL_DEPTH = "https://www.okcoin.cn/api/v1/depth.do";
    const URL_TRADES = "https://www.okcoin.cn/api/v1/trades.do";
    const URL_KLINE = "https://www.okcoin.cn/api/v1/kline.do";
    const URL_USER_INFO = "https://www.okcoin.cn/api/v1/userinfo.do";
    const URL_TRADE = "https://www.okcoin.cn/api/v1/trade.do";
    const URL_CANCEL_ORDER = "https://www.okcoin.cn/api/v1/cancel_order.do";
    const URL_ORDER_INFO = "https://www.okcoin.cn/api/v1/order_info.do";


    /**
     * 获取OKCoin行情
     * @param string $symbol btc_cny,ltc_cny,eth_cny
     * @return mixed
     */
    public function ticker($symbol = 'btc_cny')
    {
        $curl = new Curl();
        $res = $curl->get(self::URL_TICKER, ['symbol' => $symbol]);
        return json_decode($res, true);
    }

    /**
     * 获取OKCoin市场深度
     * @param string $symbol
     * @param int $size
     * @param float $merge
     * @return mixed
     */
    public function depth($symbol = 'btc_cny', $size = 200, $merge = 1)
    {
        $curl = new Curl();
        $param['symbol'] = $symbol;
        $param['size'] = $size;
        //$param['merge'] = $merge;
        $res = $curl->get(self::URL_DEPTH, $param);

        return json_decode($res, true);
    }

    /**
     * 获取OKCoin最近600交易信息
     * @param string $symbol
     * @param int $since
     * @return mixed
     */
    public function trades($symbol = 'btc_cny', $since = 0)
    {
        $curl = new Curl();
        $param['symbol'] = $symbol;
        if (!empty($param)) {
            $param['since'] = (int)$since;
        }
        $res = $curl->get(self::URL_TRADES, $param);
        return json_decode($res, true);
    }

    /**
     * @param string $symbol btc_cny：比特币， ltc_cny：莱特币 eth_cny :以太坊
     * @param string $type 1min : 1分钟,3min : 3分钟,5min : 5分钟,15min : 15分钟,30min : 30分钟,1day : 1日,3day : 3日,1week : 1周,1hour : 1小时,2hour : 2小时,4hour : 4小时,6hour : 6小时,12hour : 12小时,
     * @param int $size 否(默认全部获取) 指定获取数据的条数
     * @param int $since 否(默认全部获取) 时间戳（eg：1417536000000）。 返回该时间戳以后的数据
     * @return mixed
     */
    public function kline($symbol = 'btc_cny', $type = '1hour', $size = 0, $since = 0)
    {
        $curl = new Curl();
        $param['symbol'] = $symbol;
        $param['type'] = $type;
        if (!empty($size)) {
            $param['size'] = (int)$size;
        }
        if (!empty($since)) {
            $param['since'] = (int)$since;
        }
        $res = $curl->get(self::URL_KLINE, $param);
        return json_decode($res, true);
    }

    /**
     * {
     * info: {
     * funds: {
     *  asset: {
     *      net: "74909.27",
     *      total: "74909.27"
     * },
     * free: {
     *      btc: "0.000586",
     *      cny: "48098.37592",
     *      eth: "0.000247",
     *      ltc: "0.008787"
     * },
     * freezed: {
     *      btc: "0",
     *      cny: "26800",
     *      eth: "0",
     *      ltc: "0"
     *  }
     * }
     * },
     * result: true
     * }
     * @param string $apiKey
     * @return mixed
     */
    public function userInfo()
    {
        $apiKey = config('config.api.api_key');

        $curl = new Curl();
        $data['api_key'] = $apiKey;
        $data = $this->getSign($data);
        $userInfo = $curl->post(self::URL_USER_INFO, $data);
        return json_decode($userInfo, true);
    }

    /**
     * @param string $symbol btc_cny: 比特币 ltc_cny: 莱特币 eth_cny :以太坊
     * @param string $type 买卖类型： 限价单（buy/sell） 市价单（buy_market/sell_market）
     * @param $price 下单价格 [限价买单(必填)： 大于等于0，小于等于1000000 | 市价买单(必填)： BTC :最少买入0.01个BTC 的金额(金额>0.01*卖一价) / LTC :最少买入0.1个LTC 的金额(金额>0.1*卖一价)] / ETH :最少买入0.01个ETH 的金额(金额>0.01*卖一价)] 市价卖单不传price
     * @param $amount 交易数量 [限价卖单（必填）：BTC 数量大于等于0.01 / LTC 数量大于等于0.1 / ETH 数量大于等于0.01 | 市价卖单（必填）： BTC :最少卖出数量大于等于0.01 / LTC :最少卖出数量大于等于0.1 / ETH :最少卖出数量大于等于0.01] 市价买单不传amount
     * @return mixed
     * {"result":true,"order_id":123456}
     */
    public function trade($price, $amount, $symbol = 'ltc_cny', $type = 'buy')
    {
        return ;
        $apiKey = config('config.api.api_key');

        $curl = new Curl();
        $data['api_key'] = $apiKey;
        $data['symbol'] = $symbol;
        $data['type'] = $type;
        $data['price'] = $price;
        $data['amount'] = $amount;

        $data = $this->getSign($data);
        $result = $curl->post(self::URL_TRADE, $data);
        return json_decode($result, true);
    }

    /**
     * @param string $symbol
     * @param $orderId 订单ID(多个订单ID中间以","分隔,一次最多允许撤消3个订单)
     * @return mixed
     */
    public function cancelOrder($orderId, $symbol = 'ltc_cny')
    {
        $apiKey = config('config.api.api_key');

        $curl = new Curl();
        $data['api_key'] = $apiKey;
        $data['symbol'] = $symbol;
        $data['order_id'] = $orderId;

        $data = $this->getSign($data);
        $result = $curl->post(self::URL_CANCEL_ORDER, $data);
        return json_decode($result, true);
    }

    /**
     * @param $symbol
     * @param int $orderId 订单ID -1:未完成订单，否则查询相应订单号的订单
     * @return mixed
     *
     * Array
     * (
     * [orders] => Array
     * (
     *  [0] => Array
     *  (
     *      [amount] => 1
     *      [avg_price] => 0
     *      [create_date] => 1500198703000
     *      [deal_amount] => 0
     *      [order_id] => 432064128
     *      [orders_id] => 432064128
     *      [price] => 260
     *      [status] => 0
     *      [symbol] => ltc_cny
     *      [type] => buy
     *  )
     *  )
     * [result] => 1
     * )
     */
    public function orderInfo($orderId = -1, $symbol = 'ltc_cny')
    {
        $apiKey = config('config.api.api_key');

        $curl = new Curl();
        $data['api_key'] = $apiKey;
        $data['symbol'] = $symbol;
        $data['order_id'] = $orderId;

        $data = $this->getSign($data);
        $result = $curl->post(self::URL_ORDER_INFO, $data);
        return json_decode($result, true);
    }

    /**
     * @param $param
     * @return array|bool
     */
    private function getSign($param)
    {
        if (empty($param)) return [];
        ksort($param);
        $str = '';
        foreach ($param as $key => $val) {
            $str .= $key . '=' . $val . '&';
        }
        if (!empty($str)) {
            $secretKey = config('config.api.secret_key');
            $str = $str . 'secret_key=' . $secretKey;
        }
        $param['sign'] = strtoupper(md5($str));

        return $param;
    }
}