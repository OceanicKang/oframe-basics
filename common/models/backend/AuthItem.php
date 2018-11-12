<?php

namespace oframe\basics\common\models\backend;

use Yii;
use oframe\basics\common\helpers\SysArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

abstract class AuthItem extends ActiveRecord
{
    // 角色
    const ROLE = 1;

    // 权限
    const AUTH = 2;

    /**
     * @var array [<description>]
     */
    public static $typeExplain = [
        self::ROLE => '角色',
        self::AUTH => '权限',
    ];

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
            [['name', 'type'], 'required'],

            [['type', 'append', 'updated', 'id', 'pid', 'level', 'sort'], 'integer'],

            [['description', 'data'], 'string'],

            [['name', 'rule_name'], 'string', 'max' => 64],

            [['name', 'id'], 'unique'],

            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => $this -> auth_rule, 'targetAttribute' => ['rule_name' => 'name']],

            ['id', 'unique'],

            ['sort', 'trim'],

            [['pid','sort'], 'default', 'value' => 0],

            ['level', 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'        => '权限路由',
            'type'        => '类型',
            'description' => '标题',
            'rule_name'   => 'Rule Name',
            'data'        => 'Data',
            'id'          => '标识id',
            'pid'         => '父级id',
            'level'       => '级别',
            'sort'        => '排序',
            'append'      => '创建时间',
            'updated'     => '更新时间',
        ];
    }

    /**
     * 分配权限
     */
    public static function setAccreditAssign($parent, $children)
    {
        $data = [];

        if ($children) {

            foreach ($children as $k => $child) {

                $data[$k]['parent'] = $parent;

                $data[$k]['child'] = $child;

            }
            
        }

        $transaction = Yii::$app -> db -> beginTransaction();

        try {

            $result = AuthItemChild::deleteAll('parent = :parent', [':parent' => $parent]);

            if ($result !== 0 && !$result) throw new \Exception('权限预处理失败');

            $result = $data ? 
                        Yii::$app -> db -> createCommand() -> batchInsert(AuthItemChild::tableName(), [
                            'parent',
                            'child',
                        ], $data) -> execute() : true;

            if (!$result) throw new \Exception('分配权限失败');

            $transaction -> commit();

        } catch (\Exception $e) {

            $transaction -> rollback();

            return $e -> getMessage();

        }

        return true;
    }


    /**
     * 插入前行为
     */
    public function beforeSave($insert)
    {
        if ($this -> isNewRecord) {

            // 设置唯一id
            $model = self::find() -> orderBy('id desc') -> select('id') -> one();

            $id = $model['id'];

            $this -> id = $id ? $id + 1 : 1;

        }

        return parent::beforeSave($insert);
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
