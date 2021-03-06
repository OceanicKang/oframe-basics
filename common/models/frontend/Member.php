<?php

namespace oframe\basics\common\models\frontend;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Member extends \common\models\base\User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['status', 'append', 'updated'], 'integer'],

            [['username', 'nickname', 'password_hash', 'password_reset_token', 'email', 'avatar'], 'string', 'max' => 255],

            ['mobile_phone', 'string', 'max' => 20],

            [['auth_key'], 'string', 'max' => 32],

            [['username', 'email', 'password_reset_token'], 'unique'],

            ['avatar', 'default', 'value' => Yii::$app -> config -> get('WEB_DEFAULT_AVATAR')]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'username'      => '用户名',
            'nickname'      => '昵称',
            'auth_key'      => 'Auth Key',
            'password_hash' => '密码',
            'password_reset_token' => '重置密码token',
            'avatar'        => '头像',
            'email'         => '邮箱',
            'mobile_phone'  => '手机',
            'status'        => 'Status',
            'append'        => '创建时间',
            'updated'       => '修改时间',
        ];
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