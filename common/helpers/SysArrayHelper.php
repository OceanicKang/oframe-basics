<?php
namespace oframe\basics\common\helpers;

use Yii;

class SysArrayHelper
{
    /**
     * 递归 分组 
     * @param  array  $items      待处理的数组
     * @param  string $id         id的key
     * @param  int    $pid        父id的value
     * @param  string $pidName    父id的key
     * @return array
     */
    public static function itemsMerge($items, $idName = 'id', $pidName = 'pid', $pid = 0)
    {
        $arr = array();

        foreach ($items as $v) {

            if ($v[$pidName] == $pid) {

                $v['child'] = self::itemsMerge($items, $idName, $pidName, $v[$idName]);

                $arr[] = $v;

            }

        }

        return $arr;
    }

}