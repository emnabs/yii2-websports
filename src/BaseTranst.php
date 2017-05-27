<?php

namespace emhome\websports\src;

use yii\base\Object;
use yii\web\Response;

/**
 * 赛事数据接口基类
 *
 * @author emhome <emhome@163.com>
 * @since 2.0
 */
abstract class BaseTranst extends Object implements ApiInterface {

    /**
     * 接口地址
     * @var string
     */
    public $url;

    /**
     * 请求参数
     * @var string
     */
    protected $params = [];

    /**
     * 返回内容格式
     * @var string
     */
    public $format = 'json';

    /**
     * 赛季（年份）
     * @var string
     */
    private $_season;

    /**
     * 轮次
     * @var string
     */
    private $_round;

    /**
     * 小组
     * @var string
     */
    private $_group;

    /**
     * @inheritdoc
     */
    public function getSeason() {
        return $this->_season;
    }

    /**
     * Sets season
     * @param string|integer $season season
     * @return $this self reference.
     */
    public function setSeason($season) {
        $this->_season = $season;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRound() {
        return $this->_round;
    }

    /**
     * Sets round
     * @param array $round round
     * @return $this self reference.
     */
    public function setRound($round) {
        $this->_round = $round;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getGroup() {
        return $this->_group;
    }

    /**
     * Sets group
     * @param array $group group
     * @return $this self reference.
     */
    public function setGroup($group) {
        $this->_group = $group;
        return $this;
    }

    /**
     * Sets params
     * @param array $params params specification.
     */
    public function setParams($params) {
        $this->params = $params;
    }

    /**
     * 接口请求执行
     *
     * @return minxed
     */
    public function execute() {
        $data = self::httpGet($this->url, $this->params);
        if ($this->format == Response::FORMAT_JSON && $data) {
            return \yii\helpers\Json::decode($data);
        }
        return $data;
    }

    /**
     * GET 请求
     * @param string $url
     * @param string $param
     */
    protected static function httpGet($url, $param = []) {
        $paramSplitChar = '?';
        $ch = curl_init();
        //格式化url
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['scheme']) && $parsedUrl['scheme'] == "https") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (!isset($parsedUrl['host'])) {
            return false;
        }
        if (isset($parsedUrl['query'])) {
            $paramSplitChar = '&';
        }
        if (!empty($param)) {
            $param = $paramSplitChar . http_build_query($param);
        } else {
            $param = '';
        }
        if (isset($parsedUrl['fragment'])) {
            $url = str_replace('#', $param . '#', $url);
        } else {
            $url .= $param;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);

        if (intval($status["http_code"]) == 200) {
            return $response;
        } else {
            return false;
        }
    }

    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @return string content
     */
    protected static function httpPost($url, $param = []) {
        $ch = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (!empty($param)) {
            $param = http_build_query($param);
        } else {
            $param = '';
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
        if (intval($status["http_code"]) == 200) {
            return $response;
        } else {
            return false;
        }
    }

}
