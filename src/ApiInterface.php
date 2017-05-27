<?php

namespace common\components\sports\src;

/**
 * SmserInterface is the interface that should be implemented by smser classes.
 *
 * A smser should mainly support creating and sending [[MessageInterface|sms messages]]. It should
 * also support composition of the message body through the view rendering mechanism. For example,
 *
 * ```php
 * Yii::$app->smser->compose('contact/html', ['contactForm' => $form])
 *     ->setFrom('from@domain.com')
 *     ->setTo($form->email)
 *     ->setSubject($form->subject)
 *     ->send();
 * ```
 *
 * @see MessageInterface
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
