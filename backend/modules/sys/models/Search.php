<?php
namespace oframe\basics\backend\modules\sys\models;

use Yii;

/**
 * 查询 Model
 */
class Search extends \yii\base\Model
{
    /**
     * 登录名
     * @var string
     */
    public $username;

    /**
     * 手机号
     * @var string
     */
    public $mobile_phone;

    /**
     * 邮箱
     * @var string
     */
    public $email;

    /**
     * 角色 ID
     * @var int
     */
    public $role_id;

    public function rules()
    {
        return [
            [['username', 'mobile_phone', 'email', 'role_id'], 'safe']
        ];
    }
}