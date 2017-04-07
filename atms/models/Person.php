<?php

namespace atms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use common\utils\Gender;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "person".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property boolean $gender
 * @property string $birthdate
 * @property string email
 * @property string phone_number
 * @property string $ssn
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address[] $addresses
 * @property Address   $address
 * @property Customer[] $customers
 * @property Employee[] $employees
 */
class Person extends ActiveRecord
{

     const PERSON_MALE = 1;
     const PERSON_FEMALE = 0;


    public $fullname;
    public $sex;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%person}}';
    }

    /**
     * 
     * @return array of columns mapped to database columns
     */
    public function fields() {
        return [
            'id',
            'firstname',
            'middlename',
            'lastname',
            'gender',
            'birthdate',
            'email',
            'phone_number',
            'ssn',
            'created_at',
            'updated_at'
        ];
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
            [['firstname', 'middlename', 'lastname', 'email','phone_number' ], 'string', 'max' => 100],
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
            'middlename' => 'Tên đệm' ,
            'lastname' => 'Họ',
            'gender' => 'Giới tính',
            'email' => 'Email',
            'phone_number'  => 'SĐT',
            'birthdate' => 'Ngày sinh',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Thời điểm cập nhật',
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
                'value'     => date("Y-m-d H:i:s"),
            // if you're using datetime instead of UNIX timestamp:
            // 'value' => new Expression('NOW()'),
            ],
        ];
    }

    
    public static function  getPersonByID($person_id)
    {
        return static::findOne(['id' => $person_id]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['person_id' => 'id']);
    }


    /**
     * @return Address $address
     */
    public  function getCurrentAddresses()
    {
        return Address::findOne(['person_id' => $this->id, 'is_current' => 1]);
    }

    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['person_id' => 'id','is_current' => 1]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasOne(Employee::className(), ['person_id' => 'id']);
    }
    
    /**
     * 
     * @param int $id
     * @return Person
     */
    public static function getPerson($id){
        
        return static::findOne([ 'id'=> $id ]);
    }
    
    /**
     * 
     * @return string  return birthdate in d-m-Y format
     */
    public function getBirthdate()
    {
        if (! isEmpty($this->birthdate))
        {
            return  \DateTime::createFromFormat("Y-m-d", $this->birthdate)->format("d-m-Y");
        }else{
            return null;
        }
        
   }
    
    /**
     * 
     * @return string  return created date in d-m-Y H:M:S format
     */
    public function getCreatedAt()
    {
         if (! isEmpty($this->created_at))
        {
            return  \DateTime::createFromFormat("Y-m-d H:i:s", $this->created_at)->format("d-m-Y H:i:s");
        }else{
            return null;
        }
    }
    
    /**
     * 
     * @return string return updated date in d-m-Y H:M:S format
     */
    public function getUpdatedAt()
    {
         if (! isEmpty($this->updated_at))
        {
            return  \DateTime::createFromFormat("Y-m-d H:i:s", $this->updated_at)->format("d-m-Y H:i:s");
        }else{
            return null;
        }
    }
    
    /**
     * 
     * @return string return Nam or Nu
     */
    public function getSex(){
        return $this->gender== Gender::FEMALE?"Nữ":"Nam";
    }
    
    public function getFullname(){
        return $this->lastname . ' ' . $this->middlename . ' ' . $this->firstname;
    }
   
    /**
     * 
     * @param string set d-m-Y format
     */
    public function setBirthdate($birthdate){
        $this->birthdate =\DateTime::createFromFormat("d-m-Y", $birthdate)->format("Y-m-d");
    }
    
    public function updateLastUpdate(){
       $this->updated_at = date("Y-m-d h:i:s",time());
       $this->update();
    }

}
