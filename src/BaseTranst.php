<?php

namespace common\components\sports\src;

use Yii;
use yii\helpers\FileHelper;
use yii\base\Object;
use common\helpers\Utils;
use yii\web\Response;

/**
 * 新浪体育接口API基类
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
     * Sets message signature
     * @param array|callable|\Swift_Signer $season signature specification.
     * See [[addSignature()]] for details on how it should be specified.
     * @return $this self reference.
     * @since 2.0.6
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
     * Sets message signature
     * @param array|callable|\Swift_Signer $round signature specification.
     * See [[addSignature()]] for details on how it should be specified.
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
     * Sets message signature
     * @param array|callable|\Swift_Signer $group signature specification.
     * See [[addSignature()]] for details on how it should be specified.
     * @return $this self reference.
     */
    public function setGroup($group) {
        $this->_group = $group;
        return $this;
    }

    /**
     * Sets message signature
     * @param array|callable|\Swift_Signer $group signature specification.
     * See [[addSignature()]] for details on how it should be specified.
     * @return $this self reference.
     */
    public function setParams($params) {
        $this->params = $params;
    }

    /**
     * 获取状态信息
     *
     * @return string
     */
    public function execute() {
        $url = $this->url;
        if (!empty($this->params)) {
            $url = $this->url . '?' . http_build_query($this->params);
        }
        $data = Utils::httpGet($url);
        if ($this->format == Response::FORMAT_JSON) {
            return \yii\helpers\Json::decode($data);
        }
        return $data;
    }

}
