<?php

namespace atms\models;

use Yii;

/**
 * This is the model class for table "{{%ward}}".
 *
 * @property integer $id
 * @property string $code
 * @property integer $district_id
 * @property string $name
 * @property string $type
 * @property string $location
 * @property string $keyword
 *
 * @property District $district
 */
class Ward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ward}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'district_id', 'name', 'type'], 'required'],
            [['district_id'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 100],
            [['type', 'location'], 'string', 'max' => 30],
            [['keyword'], 'string', 'max' => 10],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
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
            'district_id' => 'District ID',
            'name' => 'Name',
            'type' => 'Type',
            'location' => 'Location',
            'keyword' => 'Keyword',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }
}
