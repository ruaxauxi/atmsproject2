<?php

namespace atms\models;

use Yii;
use yii\db\ActiveRecord;


class Customer extends \yii\db\ActiveRecord
{

    const DELETED = 1;
    const UNDELETED = 0;


    /**
     * @inheritdoc
     */

    /**
     * This is the model class for table "customer", "person" and "address".
     *
     * @property integer $id
     * @property integer $user_id
     * @property integer $person_id
     * @property integer $company_id
     * @property string $company
     * @property string $firstname
     * @property string $lastname
     * @property string $middlename
     * @property integer $gender
     * @property string $phone_number
     * @property string $birthdate
     * @property string $ssn
     * @property string $created_at
     * @property string $updated_at
     * @property string $username
     * @property integer $status
     * @property string $email
     * @property string $avatar
     * @property integer $usertype
     * @property string $last_login
     * @property string $last_updated
     * @property string $user_created_at
     * @property integer $address_id
     * @property string $house_number
     * @property string $street
     * @property string $ward
     * @property string $district
     * @property string $province
     * @property string $phone
     * @property string $address_updated_at
     * @property integer $deleted
     */



   // person table
    public $firstname;
    public $lastname;
    public $middlename;
    public $gender;
    public $birthdate;
    public $ssn;
    public $email;
    public $phone_number;
    public $created_at;
    public $updated_at;

    // company
   /* public $company_id;
    public $company;*/

    // user table (optional)
    public $username;
    public $status;

    public $avatar;
    public $usertype;
    public $last_login;
    public $last_updated;
    public $user_created_at;

    // address
    public $address_id;
    public $house_number;
    public $street;
    public $ward;
    public $district;
    public $province;
    public $phone;
    public $address_updated_at;
    public $address_deleted;

    public static function tableName()
    {
        return '{{%customer}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'person_id'], 'integer'],
            [['person_id'], 'required'],
            [['created_at'], 'safe'],
            //[['phone_number'], 'string', 'max' => 255],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'person_id' => 'Person ID',
            'created_at' => 'Created At',
            'phone_number' => 'Phone Number',
            'deleted'       => 'Đã xoá',
            'fullName'  => "Họ",
            'firstName' => 'Tên',
            'addressProvince'   => 'Tỉnh/TP',
            'addressDistrict' => 'Khu vực'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['person_id' => 'person_id'])
            ->where([
                'is_current'    => 0,
                'deleted' => Address::UNDELETED
            ])->orderBy(["created_at" => 'desc']);
    }
    
    public function getCurrentAddress()
    {
        
        $address = $this->hasOne(Address::className(), ["person_id" => 'person_id'])
            ->leftJoin("province", "province.id = address.province_id")
            ->leftJoin("district", "district.id = address.district_id")
            ->leftJoin("ward", "ward.id = address.ward_id")
            ->select("address.house_number, address.street, ward.name as ward, district.name as district, province.name as province, address.phone")
            ->where(['is_current' => 1, 'deleted' => Address::UNDELETED]);

        return $address;
        
        //return $this->hasOne(Address::className(), ["person_id" => 'person_id'])->where(['is_current' => 1, 'deleted' => Address::UNDELETED]);
    }

    public function getAddressHouseNumber()
    {
        return isset($this->currentAddress)?$this->currentAddress->house_number:null;
    }
    public function getAddressStreet()
    {
        return isset($this->currentAddress)?$this->currentAddress->street:null;
    }

    public function getAddressWard()
    {
        return isset($this->currentAddress->ward)?$this->currentAddress->ward:null;
    }

    public function getAddressDistrict()
    {

        return isset($this->currentAddress)?$this->currentAddress->district:null;
    }

    public function getAddressProvince()
    {

        return isset($this->currentAddress->province)?$this->currentAddress->province:null;
    }

    public function getAddressPhone()
    {
        return isset($this->currentAddress)?$this->currentAddress->phone:null;
    }

    public function getAddressCreatedAt()
    {
        return isset($this->currentAddress)?$this->currentAddress->created_at:null;
    }

    public function getAddressFullAddress()
    {
        if (!isset($this->currentAddress))
        {
            return null;
        }

        $a[] = $this->currentAddress->house_number;
        $a[] = $this->currentAddress->street;
        $a[] = $this->currentAddress->ward;
        $a[] = $this->currentAddress->district;
        $a[] = $this->currentAddress->province;

        return implode(", ", array_filter($a));
    }

    public function getAddressArea()
    {
        if (!isset($this->currentAddress))
        {
            return null;
        }


        $a[] = $this->currentAddress->district;
        $a[] = $this->currentAddress->province;

        return implode(", ", array_filter($a));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(),['id' => 'person_id']);
    }

    public function getPersonFirstName()
    {
        return isset($this->person)?$this->person->firstname:null;
    }

    public function getPersonLastName()
    {
        return isset($this->person)?$this->person->lastname:null;
    }

    public function getPersonFullName()
    {
        return isset($this->person)?$this->person->lastname . ' ' .
                    $this->person->middlename  . ' '. $this->person->firstname :null;
    }

    public function getPersonLastnameAndMiddlename()
    {
        return isset($this->person)?$this->person->lastname . ' ' .
            $this->person->middlename  :null;
    }

    public function getPersonPhoneNumber()
    {
        return isset($this->person)?$this->person->phone_number:null;
    }

    public function getPersonBirthdate()
    {
        return isset($this->person)?$this->person->birthdate:null;
    }

    public function getPersonEmail()
    {
        return isset($this->person)?$this->person->email:null;
    }

    public function getPersonGender()
    {
        return isset($this->person)?$this->person->gender:null;
    }

    public function getPersonGenderText()
    {

        if (! isset($this->person)){
            return null;
        }

        return $this->person->gender == Person::PERSON_FEMALE?"Nữ":"Nam";

    }

    public function getPersonTitle()
    {

        if (! isset($this->person)){
            return null;
        }

        return $this->person->gender == Person::PERSON_FEMALE?"Bà/Chị":"Ông/Anh";

    }

    public function getPersonGenderIcon()
    {

        if (! isset($this->person)){
            return null;
        }

        return $this->person->gender == Person::PERSON_FEMALE?"fa-female":"fa-male";

    }

    public function getPersonSsn()
    {
        return isset($this->person)?$this->person->ssn:null;
    }

    public function getPersonCreatedAt()
    {
        return isset($this->person)?$this->person->created_at:null;
    }

    public function getPersonUpdatedAt()
    {
        return isset($this->person)?$this->person->updated_at:null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getCompanyName()
    {
        return isset($this->company)?$this->company->company:null;
    }

    public function getCompanyWebsite()
    {
        return isset($this->company)?$this->company->website:null;
    }

    public function getAddress()
    {
        return $this->hasOne(Address::className(),['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerRequests()
    {
        return $this->hasMany(CustomerRequests::className(), ['customer_id' => 'id']);
    }

    /**
     * @param $id
     * @return ActiveRecord
     */
    public function getCustomer($id)
    {
        return static::findOne(["id" => $id]);
    }


   /* public function getCustomerInfo($id)
    {
        $customer = static::findOne(['id' => $id]);
        if ($customer)
        {
            $customerInfo = new CustomerInfo();
            $customerInfo->loadData($customer);

            return $customerInfo;


        }else{
            return null;
        }

    }*/


    /*public static function findCustomerInfo()
    {
        $sql = "SELECT c.`id`, c.`user_id`, c.`person_id`,  c.`company_id`, c.`deleted`,  ";
        $sql .= " p.`firstname`, p.`lastname`, p.`middlename`, p.`gender`, p.`birthdate`,  ";
        $sql .= " p.`ssn`, p.`created_at`, p.`updated_at`, p.`phone_number`, p.`email`,  ";
        $sql .= " u.`username`, u.`status`, u.`avatar`, u.`usertype`, u.`last_login` , ";
        $sql .= " u.`last_updated`, u.`created_at` as user_created_at,  ";
        $sql .= " a.`house_number`, a.`street`, a.`ward`, a.`district`, a.`city`, a.`phone`, ";
        $sql .= " a.`created_at` as address_created_at, a.`deleted` as address_deleted, co.`company` ";
        $sql .= " FROM customer c INNER JOIN person p ON c.person_id = p.`id`   ";
        $sql .= "       LEFT JOIN address a ON a.person_id = p.`id` AND a.is_current = 1 ";
        $sql .= "       LEFT JOIN `user` u ON c.user_id = u.`id` ";
        $sql .= "       LEFT JOIN `company` co ON c.company_id = co.`id` ";

        return static::findBySql($sql);
    }*/

    public static function findCustomersInfo(){

        return static::find()
            ->innerJoin("person", "person.`id` = " . static::tableName().".person_id")
            ->leftJoin("user", "`user`.`id` = " . static::tableName(). ".user_id")
           ->leftJoin("address", "address.`person_id` =  " . static::tableName().  ".`person_id`")
            ->leftJoin("company", "company.`id` = " . static::tableName().".company_id")
            ->where(['customer.deleted' => static::UNDELETED])
            ->groupBy(['customer.id']);

    }

    public static function findCustomerInfo($id){

        return static::find()
            ->innerJoin("person", "person.`id` = " . static::tableName().".person_id")
            ->leftJoin("user", "`user`.`id` = " . static::tableName(). ".user_id")
            ->leftJoin("address", "address.`person_id` =  " . static::tableName().  ".`person_id`")
            ->leftJoin("company", "company.`id` = " . static::tableName().".company_id")
            ->where([
                    'customer.deleted' => static::UNDELETED,
                    'customer.id' => $id
                ]
            );


    }

}
