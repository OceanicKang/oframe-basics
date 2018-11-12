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

    /**
     * 根据父 ID 返回所有子孙 ID
     * @param array $cate 类别数据
     * @param int $pid 父id
     * @return array [<description>]
     */
    public static function getChildsId($cate, $pid)
    {
        $arr = [];

        foreach ($cate as $v) {

            if ($v['pid'] == $pid) {

                $arr[] = $v['id'];

                $arr = array_merge($arr, self::getChildsId($cate, $v['id']));

            }

        }

        return $arr;
    }

}