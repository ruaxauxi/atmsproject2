<?php

namespace atms\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $person_id
 * @property string $house_number
 * @property string $street
 * @property string $ward
 * @property string $district
 * @property string $city
 * @property string $phone
 * @property string $created_at
 * @property integer $is_current
 * @property integer $deleted
 *
 * @property Person $person
 */
class Address extends \yii\db\ActiveRecord
{

    const DELETED = 1;
    const UNDELETED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id'], 'required'],
            [['person_id', 'is_current', 'deleted'], 'integer'],
            [['created_at'], 'safe'],
            [['house_number'], 'string', 'max' => 100],
            [['street', 'ward', 'district', 'city', 'phone'], 'string', 'max' => 255],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'house_number' => 'House Number',
            'street' => 'Street',
            'ward' => 'Ward',
            'district' => 'District',
            'city' => 'City',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'is_current' => 'Is Current',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    public static function getCurrentAddress($person_id)
    {
        return static::findOne(['person_id' => $person_id, 'is_current' => 1]);
    }
}
