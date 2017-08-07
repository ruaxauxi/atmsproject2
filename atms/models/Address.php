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
 * @property string $ward_id
 * @property string $district
 * @property string $district_id
 * @property string $province
 * @property string $province_id
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

    public $ward;
    //public $ward_id;
    public $district;
    //public $district_id;
    public $province;
    //public $province_id;

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
            [['person_id', 'is_current', 'deleted',  'ward_id', 'district_id', 'province_id'], 'integer'],
            [['created_at'], 'safe'],
            [['house_number'], 'string', 'max' => 100],
            [['street','phone'], 'string', 'max' => 255],
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
            'ward_id' => 'Ward',
            'district_id' => 'District',
            'province_id' => 'Province',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'is_current' => 'Is Current',
            'deleted' => 'Deleted',
        ];
    }

    public function isEmpty()
    {
        return (empty($this->house_number)  && empty($this->street) && empty($this->ward_id) && empty($this->district_id)
                && empty($this->province_id) );
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

    public  function findProvinceID()
    {
        $district = District::findOne(['id' => $this->district_id]);

        $this->province_id = $district->province_id;
    }

    public function updateCurrentAddress()
    {
        Yii::$app->db->createCommand()
            ->update('address', ['is_current' => 0], ['person_id' => $this->person_id] )
            ->execute();
    }
}
