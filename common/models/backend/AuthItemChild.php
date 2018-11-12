<?php

namespace oframe\basics\common\models\backend;

use Yii;

/**
 * This is the model class for table "{{%auth_item_child}}".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $parent0
 * @property AuthItem $child0
 */
abstract class AuthItemChild extends \yii\db\ActiveRecord
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
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => $this -> auth_item, 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => $this -> auth_item, 'targetAttribute' => ['child' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

}
