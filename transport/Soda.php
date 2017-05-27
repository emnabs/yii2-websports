<?php

namespace emhome\websports\transport;

/**
 * 搜达体育
 *
 * @author emhome <emhome@163.com>
 * @since 2.0
 */
class Soda extends \emhome\websports\src\BaseTranst {

    /**
     * 请求地址
     * @var string
     */
    public $url = 'http://www.sodasoccer.com';

    /**
     * 状态信息
     * @var string
     */
    public $format = 'html';

    /**
     * 页面路径
     * @var string
     */
    public $path = '/top/{id}/player_goal.html';

    /**
     * @inheritdoc
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @inheritdoc
     */
    public function schedule() {
        return;
    }

    /**
     * @inheritdoc
     */
    public function lineup($matchid) {
        return;
    }

    /**
     * @inheritdoc
     */
    public function standing() {
        return;
    }

    /**
     * @inheritdoc
     */
    public function playerOrder($type = null, $limit = 50) {
        $response = $this->execute();
        $content = preg_replace("/[\t\n\r]+/", "", $response);
        preg_match('/<div class=\"odtable\"><table[^>]*?>(.*)<\/table><\/div>/', $content, $matches);
        return $this->tableToArray($matches[1], $this->getSeason());
    }

    /**
     * 获取赛事射手榜
     */
    public function scorer($id) {
        $path = str_replace('{id}', $id, $this->path);
        $this->setUrl($this->url . $path);
        return $this->playerOrder();
    }

    /**
     * 表格转数组
     */
    private function tableToArray($table, $id) {
        $headers = [
            'playername' => '球员',
            'teamname' => '球队',
            'goal' => '进球',
            'normal' => '普通进球',
            'penalty' => '点球',
            'freekick' => '任意球',
            'header' => '头球',
        ];

        $patterns = [
            0 => "'<table[^>]*?>'si",
            1 => "'<tr[^>]*?>'si",
            2 => "'<(td|th)[^>]*?>'si",
            3 => "'<\/(td|th)>'si",
            4 => "'\t<\/tr>'si",
        ];
        $replacements = [
            0 => '',
            1 => '',
            2 => '',
            3 => "\t",
            4 => "\n",
        ];

        ksort($patterns);
        ksort($replacements);

        $string = preg_replace($patterns, $replacements, $table);

        $data = [];
        $tableFrame = explode("\n", strip_tags($string));

        $keys = [];
        foreach ($tableFrame as $key => $line) {
            $item = explode("\t", $line);
            if (empty($item)) {
                continue;
            }
            if (!$key) {
                foreach ($item as $it) {
                    $keys[] = array_search($it, $headers);
                }
                continue;
            }
            $temp = array_combine($keys, $item);
            $data[] = [
                'seasonid' => $id,
                'ranking' => $key,
                'teamname' => $temp['teamname'],
                'playername' => $temp['playername'],
                'goal' => $temp['goal'],
                'penalty' => $temp['penalty'],
            ];
        }
        return $data;
    }

}
