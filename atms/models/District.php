<?php

namespace atms\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $code
 * @property integer $province_id
 * @property string $name
 * @property string $type
 * @property string $location
 * @property string $keyword
 *
 * @property Province $province
 * @property Ward[] $wards
 */
class District extends \yii\db\ActiveRecord
{

    public $province;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'type'], 'required'],
            [['province_id'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 100],
            [['type', 'location'], 'string', 'max' => 30],
            [['keyword'], 'string', 'max' => 10],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'province_id' => 'Province ID',
            'name' => 'Name',
            'type' => 'Type',
            'location' => 'Location',
            'keyword' => 'Keyword',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWards()
    {
        return $this->hasMany(Ward::className(), ['district_id' => 'id']);
    }
}
