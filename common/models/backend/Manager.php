<?php

namespace oframe\basics\common\models\backend;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\backend\AuthAssignment;

class Manager extends \common\models\base\User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_manager}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'append', 'updated'], 'integer'],
            [['username', 'nickname', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username', 'email', 'password_reset_token'], 'unique'],
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
            'email'         => '邮箱',
            'status'        => 'Status',
            'append'        => '创建时间',
            'updated'       => '修改时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleName()
    {
        return $this -> hasOne(AuthAssignment::className(), ['user_id' => 'id']);
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