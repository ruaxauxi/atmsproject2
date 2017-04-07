<?php

namespace atms\models;

use Yii;

/**
 * This is the model class for table "airport".
 *
 * @property string $code
 * @property string $name
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $utc_time
 * @property boolean $deleted
 * @property boolean $openning
 *
 * @property Flight $flight
 * @property Flight $flight0
 * @property Request[] $requests
 * @property Request[] $requests0
 */
class Airport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'airport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'country'], 'required'],
            [['deleted', 'openning'], 'boolean'],
            [['code'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 255],
            [['city', 'state', 'country'], 'string', 'max' => 100],
            [['utc_time'], 'string', 'max' => 9],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Mã sân bay',
            'name' => 'Tên sân bay',
            'city' => 'Thành phố',
            'state' => 'Bang/Vùng',
            'country' => 'Quốc gia',
            'utc_time' => 'Múi giờ (UTC)',
            'deleted' => 'Xoá',
            'openning' => 'Đang hoạt động',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlight()
    {
        return $this->hasOne(Flight::className(), ['from_airport' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlight0()
    {
        return $this->hasOne(Flight::className(), ['to_airport' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['from_airport' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests0()
    {
        return $this->hasMany(Request::className(), ['to_airpot' => 'code']);
    }
}
