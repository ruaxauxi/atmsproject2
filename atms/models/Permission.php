<?php

namespace atms\models;

use Yii;

/**
 * This is the model class for table "permission".
 *
 * @property integer $id
 * @property integer $permission_category_id
 * @property string $controller
 * @property string $action
 * @property string $name
 * @property integer $type
 *
 * @property PermissionCategory $permissionCategory
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permission_category_id'], 'required'],
            [['permission_category_id', 'type'], 'integer'],
            [['controller', 'action', 'name'], 'string', 'max' => 255],
            [['permission_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PermissionCategory::className(), 'targetAttribute' => ['permission_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permission_category_id' => 'Permission Category ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'name' => 'Name',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermissionCategory()
    {
        return $this->hasOne(PermissionCategory::className(), ['id' => 'permission_category_id']);
    }
}
