<?php

namespace oframe\basics\common\models\backend;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%auth_rule}}".
 *
 * @property string $name
 * @property string $data
 * @property integer $append
 * @property integer $updated
 *
 * @property AuthItem[] $authItems
 */
abstract class AuthRule extends \yii\db\ActiveRecord
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
            [['name'], 'required'],
            [['data'], 'string'],
            [['append', 'updated'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'data' => 'Data',
            'append' => 'Created At',
            'updated' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this -> hasMany($this -> auth_item, ['rule_name' => 'name']);
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
