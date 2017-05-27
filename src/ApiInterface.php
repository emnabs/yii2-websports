<?php

namespace emhome\websports\src;

/**
 * ApiInterface is the interface that should be implemented by implemented classes.
 *
 * @author emhome <emhome@163.com>
 * @since 2.0
 */
interface ApiInterface {

    /**
     * 获取赛程
     * @return 
     */
    public function schedule();

    /**
     * 获取比赛阵容
     * @return 
     */
    public function lineup($matchid);

    /**
     * 获取赛事球队积分榜
     * @return 
     */
    public function standing();

    /**
     * 获取赛事球员排行数据
     * @return 
     */
    public function playerOrder($type, $limit);
}
