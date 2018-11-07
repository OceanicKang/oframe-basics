<?php
namespace oframe\basics\common\models\common;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\enums\StatusEnum;

/**
 * This is the model class for table "{{%sys_config}}".
 *
 * @property int $id 主键
 * @property string $title 配置标题
 * @property string $name 配置标识
 * @property string $type 配置类型
 * @property string $extra 配置选项
 * @property string $explain 配置说明
 * @property string $value 配置值
 * @property int $pid 上级id
 * @property string $sort 排序
 * @property int $status 是否隐藏[-1:删除;0:禁用;1:启用]
 * @property int $level 级别
 * @property string $append 添加时间
 * @property string $updated 修改时间
 */
class Config extends ActiveRecord
{
    /**
     * 缓存 key
     *
     * @var string [<description>]
     */
    protected $_cacheKey = 'sys:config:info';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%sys_config}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['title', 'extra', 'describe'], 'trim'],

            [['title', 'name', 'status'], 'required', 'message' => '{attribute}不能为空'],

            ['title', 'string', 'max' => 50],

            ['name', 'unique', 'message' => '该配置标识已被占用'],

            [['name', 'type'], 'string', 'max' => 30],

            ['extra', 'string', 'max' => 255],

            ['describe', 'string', 'max' => 1000],

            ['value', 'string'],
            
            ['value', 'default', 'value' => ''],

            [['pid', 'sort', 'append', 'updated'], 'integer'],

            [['pid', 'sort'], 'default', 'value' => 0],

            ['level', 'default', 'value' => 1],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'title'    => '配置标题',
            'name'     => '配置标识',
            'type'     => '配置类型',
            'extra'    => '配置选项',
            'describe' => '配置说明',
            'value'    => '配置值',
            'pid'      => '父ID',
            'sort'     => '排序',
            'status'   => '状态',
            'level'    => '等级',
            'append'   => '创建时间',
            'updated'  => '修改时间',
        ];
    }

    /**
     * 获取配置值
     *
     * @param string $name    配置标识
     * @param bool   $isCache 是否从缓存读取
     * @return bool|string [<description>]
     */
    public function get($name, bool $isCache = true)
    {
        $info = $this -> getConfigInfo($isCache);

        return isset($info[$name]) ? trim($info[$name]) : false;
    }

    /**
     * 返回所有配置名及配置值
     * 
     * @param bool $isCache 是否从缓存读取
     * @return array|bool [<description>]
     */
    public function getAll(bool $isCache = true)
    {
        $info = $this -> getConfigInfo($isCache);

        return $info ? $info : false;
    }

    /**
     * 获取全部配置信息
     * 
     * @param bool $isCache 是否从缓存读取
     * @return array [<description>]
     */
    private function getConfigInfo(bool $isCache)
    {
        // 获取缓存信息
        $info = Yii::$app -> cache -> get($this -> _cacheKey);

        if (!$info || false == $isCache) {

            $config = Config::find()
                    -> where(['status' => StatusEnum::STATUS_ON])
                    -> andWhere(['NOT', ['name' => '']])
                    -> all();

            $info = array_column($config, 'value', 'name');

            // 设置缓存
            Yii::$app -> cache -> set($this -> _cacheKey, $info);

        }

        return $info;
    }

    /**
     * @param bool $insert [<description>]
     * @return bool [<description>]
     */
    public function beforeSave($insert)
    {
        // 清除缓存
        Yii::$app -> cache -> delete($this -> _cacheKey);

        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        Yii::$app -> cache -> delete($this -> _cacheKey);

        return parent::beforeDelete();
    }

    /**
     * 插入时间
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ]
        ];
    }
}

















