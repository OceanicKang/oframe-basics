<?php

namespace oframe\basics\common\models\backend;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%auth_assignment}}".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $append
 *
 * @property AuthItem $itemName
 */
abstract class AuthAssignment extends ActiveRecord
{
    /**
     * 规则类名
     * @var
     */
    protected $auth_rule;
    /**
     * 角色授权用户类
     * @var
     */
    protected $auth_assignment;
    /**
     * 角色路由类
     * @var
     */
    protected $auth_item;
    /**
     * 路由授权角色类
     * @var
     */
    protected $auth_item_child;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['item_name', 'user_id'], 'required'],

            [['append', 'updated'], 'integer'],

            [['item_name', 'user_id'], 'string', 'max' => 64],

            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => $this -> auth_item, 'targetAttribute' => ['item_name' => 'name']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => '角色名称',
            'user_id'   => '用户ID',
            'append'    => '创建时间',
            'updated'   => '修改时间'
        ];
    }

    /**
     * 获取用户角色名
     */
    public static function getManagerItem($user_id)
    {
        $model = self::findOne(['user_id' => $user_id]);

        return $model ? $model -> item_name : '未分配角色';
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
