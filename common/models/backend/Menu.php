<?php
namespace oframe\basics\common\models\backend;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\enums\StatusEnum;
use oframe\basics\common\helpers\SysArrayHelper;

/**
 * This is the model class for table "{{%sys_menu}}".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $describe 描述
 * @property int $pid 上级id
 * @property string $url 链接地址
 * @property int $sort 排序
 * @property int $status 是否显示
 * @property int $level 级别
 * @property string $type menu:功能菜单;sys:系统菜单
 * @property string $icon_class 图标class
 * @property int $append
 * @property int $updated
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * 侧边菜单
     *
     * @var string [<description>]
     */
    const TYPE_SIDE = 'side.menu';

    /**
     * 系统菜单
     *
     * @var string [<description>]
     */
    const TYPE_SYS = 'sys.menu';

    /**
     * @var array [<description>]
     */
    public static $typeExplain = [
        self::TYPE_SIDE => '侧边菜单',
        self::TYPE_SYS  => '系统菜单',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['title', 'type', 'url', 'sort'], 'trim'],

            [['title', 'status', 'url'], 'required', 'message' => '{attribute}不能为空'],

            [['describe', 'icon_class'], 'string'],

            [['pid', 'sort', 'append', 'updated'], 'integer'],

            [['pid','sort'], 'default', 'value' => 0],

            [['level'], 'default', 'value' => 1],

        ];
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'title'      => '标题',
            'describe'   => '描述',
            'pid'        => '父ID',
            'url'        => '路由',
            'sort'       => '排序',
            'status'     => '状态',
            'level'      => '级别',
            'type'       => '类型',
            'icon_class' => '图标',
            'append'     => '创建时间',
            'updated'    => '更新时间',
        ];
    }

    /**
     * 获取菜单
     * @param string $type 菜单类型
     * @param int|array $status 菜单状态
     * @return array 格式化后的菜单
     */
    public static function getMenus(string $type, $status = [StatusEnum::STATUS_ON, StatusEnum::STATUS_OFF])
    {
        $models = self::find()
                -> where(['type' => $type])
                -> andFilterWhere(['status' => $status])
                -> orderBy('sort asc')
                -> asArray()
                -> all();

        return SysArrayHelper::itemsMerge($models, 'id', 'pid', 0);
    }


    /**
     * 插入前行为
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        Yii::$app -> cache -> delete(Menu::TYPE_SIDE);
        Yii::$app -> cache -> delete(Menu::TYPE_SYS);

        return parent::beforeSave($insert);
    }

    /**
     * 删除前行为
     * 
     * @return bool
     */
    public function beforeDelete()
    {
        Yii::$app -> cache -> delete(Menu::TYPE_SIDE);
        Yii::$app -> cache -> delete(Menu::TYPE_SYS);

        return parent::beforeDelete();
    }


    /**
     * @return array
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
            ],
        ];
    }

}