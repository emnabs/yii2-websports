<?php

namespace common\components\sports\transport;

use Yii;
use yii\helpers\FileHelper;
use common\components\sports\src\BaseTranst;

/**
 * 新浪体育接口API基类
 *
 * @author emhome <emhome@163.com>
 * @since 2.0
 */
class Sina extends BaseTranst {

    /**
     * 球员数据标签
     * @var string
     * @static 1射门 2助攻 3传球 4传威胁球 5传中 6扑救 7抢断 8犯规 9被侵犯 10解围 11红黄牌 12出场时间 13进球
     */
    CONST PO_SHOT = 1;
    CONST PO_ASSISTS = 2;
    CONST PO_PASSES = 3;
    CONST PO_THREAT_SHOTS = 4;
    CONST PO_CROSS = 5;
    CONST PO_SAVES = 6;
    CONST PO_STEALS = 7;
    CONST PO_FOULS = 8;
    CONST PO_WAS_VIOLATED = 9;
    CONST PO_RESCUE = 10;
    CONST PO_RYC = 11;
    CONST PO_PLAYING_TIME = 12;
    CONST PO_GOALS = 13;

    /**
     * 请求地址
     * @var string
     */
    public $url = 'http://platform.sina.com.cn/sports_all/client_api';

    /**
     * 状态码
     * @var string
     */
    public $key = '';

    /**
     * 状态信息
     * @var string
     */
    public $type = '';

    /**
     * @inheritdoc
     */
    public function schedule() {
        $params = [
            'app_key' => $this->key,
            'type' => $this->type,
            '_sport_t_' => 'livecast',
            '_sport_a_' => 'matchesByType',
            'season' => $this->getSeason(),
            'rnd' => $this->getRound(),
        ];
        $this->setParams($params);
        $response = $this->execute();
        return $response['result'];
    }

    /**
     * @inheritdoc
     */
    public function lineup($matchid) {
        $params = [
            'app_key' => $this->key,
            '_sport_t_' => 'football',
            '_sport_s_' => 'opta',
            '_sport_a_' => 'preTeamFormation',
            'id' => $matchid,
        ];
        $this->setParams($params);
        $response = $this->execute();
        return $response['result'];
    }

    /**
     * @inheritdoc
     */
    public function standing() {
        $params = [
            'app_key' => $this->key,
            'type' => $this->type,
            '_sport_t_' => 'football',
            '_sport_s_' => 'opta',
            '_sport_a_' => 'teamOrder',
        ];
        $this->setParams($params);
        $response = $this->execute();
        return $response['result'];
    }

    /**
     * @inheritdoc
     */
    public function playerOrder($type, $limit) {
        $params = [
            'app_key' => $this->key,
            'type' => $this->type,
            '_sport_t_' => 'football',
            '_sport_s_' => 'opta',
            '_sport_a_' => 'playerorder',
            'item' => $type,
            'limit' => $limit,
        ];
        $this->setParams($params);
        $response = $this->execute();
        return $response['result'];
    }

    /**
     * 获取赛事射手榜
     */
    public function scorer($limit = 50) {
        return $this->playerOrder(self::PO_GOALS, $limit);
    }

    /**
     * 获取赛事助攻榜
     */
    public function assists($limit = 50) {
        return $this->playerOrder(self::PO_ASSISTS, $limit);
    }

}
