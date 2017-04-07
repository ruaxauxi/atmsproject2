<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $midlename
 * @property string $lastname
 * @property boolean $gender
 * @property string $birthdate
 * @property string $created_at
 * @property string $updated_at
 * @property integer $address_id
 *
 * @property Customer[] $customers
 * @property Employee[] $employees
 * @property Address $address
 */
class PersonModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lastname'], 'required'],
            [['gender'], 'boolean'],
            [['birthdate', 'created_at', 'updated_at'], 'safe'],
            [['address_id'], 'integer'],
            [['firstname', 'midlename', 'lastname'], 'string', 'max' => 100],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }
    
    public function behaviors() {

        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                //'value' => new Expression('NOW()'),
                'value'     => date("Y-m-d h:i:s"),
            // if you're using datetime instead of UNIX timestamp:
            // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Tên',
            'midlename' => 'Tên đệm',
            'lastname' => 'Họ',
            'gender' => 'Giới tính',
            'birthdate' => 'Ngày sinh',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Cập nhật lần cuối',
            'address_id' => 'Address ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }
    
    /**
     * 
     * @param type $id
     * @return type Person
     */
    public function getPerson($id){
        
        return static::findOne([
            'id'    => $id
        ]);
    }
    
    /**
     * 
     * @return type string return birthdate in d-m-Y format
     */
    public function getBirthdate(){
        return date("d-m-Y", $this->bithdate );
    }
    
    /**
     * 
     * @return type string return created date in d-m-Y H:M:S format
     */
    public function getCreatedAt(){
        return date("d-m-Y h:i:s", $this->created_at);
    }
    
    /**
     * 
     * @return type string return updated date in d-m-Y H:M:S format
     */
    public function getUpdatedAt(){
        return date("d-m-Y h:i:s", $this->created_at);
    }
    
    /**
     * 
     * @return type string return Nam or Nu 
     */
    public function getGender(){
        return $this->gender== Gender::FEMALE?"Nữ":"Nam";
    }
   
    /**
     * 
     * @param type $birthdate birthdate in d-m-Y format
     */
    public function setBirthdate($birthdate){
        $this->birthdate =\DateTime::createFromFormat("d-m-Y", $birthdate)->format("Y-m-d");
    }
    
    public function updateLastUpdate(){
       $this->updated_at = date("Y-m-d h:i:s",time());
       $this->update();
    }
}
