<?php

namespace emhome\sports;

use Yii;
use yii\helpers\FileHelper;

/**
 * 体育赛事比赛数据获取组件
 *
 * @author emhome <emhome@163.com>
 * @since 2.0
 */
class Sports extends \yii\base\Component {

    /**
     * @var string BaseTranst transport instance.
     */
    private $transportClass = 'common\components\sports\transport\Sina';

    /**
     * @var BaseTranst|array transport instance or its array configuration.
     */
    private $_transport = [];

    /**
     * @param array|\Swift_Transport $transport
     * @throws InvalidConfigException on invalid argument.
     */
    public function setTransport($transport) {
        if (!is_array($transport) && !is_object($transport)) {
            throw new InvalidConfigException('"' . get_class($this) . '::transport" should be either object or array, "' . gettype($transport) . '" given.');
        }
        $this->_transport = $transport;
    }

    /**
     * @return array|\Swift_Transport
     */
    public function getTransport() {
        if (!is_object($this->_transport)) {
            $this->_transport = $this->createTransport($this->_transport);
        }
        return $this->_transport;
    }

    /**
     * Creates Swift library object, from given array configuration.
     * @param array $config object configuration
     * @return Object created object
     * @throws \yii\base\InvalidConfigException on invalid configuration.
     */
    protected function createTransport(array $config) {
        if (!array_key_exists('class', $config)) {
            $config['class'] = $this->transportClass;
        }
        return Yii::createObject($config);
    }

    /**
     * @inheritdoc
     */
    public function compose($config = [], $class = null) {
        if ($class !== null) {
            $useClass = 'common\components\sports\transport\{ClassName}';
            $config['class'] = str_replace('{ClassName}', ucfirst($class), $useClass);
        }
        $this->_transport = $config;
        return $this->getTransport();
    }

}
