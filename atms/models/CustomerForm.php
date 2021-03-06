<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

namespace atms\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use atms\models\Province;
use atms\models\Ward;
use common\utils\StringUtils;

/**
 * Customer form
 */
class CustomerForm extends Model
{


    // person
    /**
     * @var
     */
    public $person_id;
    /**
     * @var
     */
    public $firstname;
    /**
     * @var
     */
    public $middlename;
    /**
     * @var
     */
    public $lastname;

    /*
     * @var
     */
    public $fullname;
    /**
     * @var
     */
    public $gender;
    /**
     * @var
     */
    public $birthdate;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $phone_number;
    /**
     * @var
     */
    public $ssn;
    /**
     * @var
     */
    public $person_created_at;
    /**
     * @var
     */
    public $person_updated_at;

    // address

    /**
     * @var
     */
    public $address_id;
    /**
     * @var
     */
    public $house_number;
    /**
     * @var
     */
    public $street;
    /**
     * @var
     */
    public $ward_id;
    /**
     * @var
     */
    public $district_id;
    /**
     * @var
     */
    public $province_id;
    /**
     * @var
     */
    public $phone;
    /**
     * @var
     */
    public $address_created_at;
    /**
     * @var
     */
    public $is_current;
    /**
     * @var
     */
    public $address_deleted;

    // customer
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $user_id;
    /**
     * @var
     */
    public $deleted;
    /**
     * @var
     */
    public $company_id;

    public $provinceList;
    public $wardList;
    public $companyList;

    public $area;


    public $person;
    public $address;
    public $customer;

    public $request;


    public function init()
    {

        parent::init();
        $this->provinceList = Province::find()->select(['id', 'name'])->orderBy(["name" => 'ACS'])->all();
        $this->provinceList = ArrayHelper::map($this->provinceList, "id", "name");

        $area = District::find()->innerJoin("province", "district.province_id = province.id")
            ->select(["district.`id`",
                "district.`name`",
                //'province.*',
                "province" => "province.`name`"])
            ->orderBy([
                'province.name' => 'ASC',
                'district.name' => 'ASC'
            ])->all();
        $this->area = ArrayHelper::map($area,
            "id",
            function ($model, $defaultValue) {
                return $model['name'] . ' - ' . $model['province'];
            }
        );

        $companies = Company::find()->select(['id', 'company'])->all();
        $this->companyList = ArrayHelper::map($companies, "id", "company");


    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['fullname', 'phone_number'], 'required', 'message' => 'Nhập vào {attribute}'],
            ['gender', 'required', 'message' => 'Chọn {attribute}'],
            ['gender', 'boolean'],
            //[['firstname', 'lastname', 'middlename'], 'string', 'length' => [2,100],'tooLong' => '{attribute} quá dài.', 'tooShort' => '{attribute}'],
            [['fullname'], 'string', 'length' => [2, 255], 'tooLong' => '{attribute} quá dài.', 'tooShort' => '{attribute}'],
            [['firstname', 'lastname', 'middlename'], 'trim'],
           // ['birthdate', 'date', 'format' => 'd/m/Y'],
            ['ssn', 'string', 'length' => [3, 50], 'tooLong' => '{attribute} quá dài.', 'tooShort' => '{attribute} quá ngắn'],
            ['phone_number', 'string', 'length' => [7, 100]],

            [['street'], 'string', 'length' => [2, 255], 'tooLong' => '{attribute} quá dài.', 'tooShort' => '{attribute}'],
            [['street'], 'trim'],
            ['email', 'email'],

            ['house_number', 'string', 'length' => [3, 100], 'tooLong' => '{attribute} quá dài.', 'tooShort' => '{attribute} quá ngắn'],
            // safe
            [['person_created_at', 'person_updated_at', 'address_created_at', 'is_current', 'address_created_at',
                'address_deleted', 'company_id'], 'safe'],

            // [['password'], "string","max" => 20, 'tooLong' => '{attribute} quá dài.', 'tooShort' => 'Mật khẩu quá ngắn.', "message" => "Nhập vào {attribute} chứa các ký tự."],
            // rememberMe must be a boolean value
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
        ];
    }

    public function isNewRecord()
    {
        return true;
    }

    public function loadById($id)
    {
        $customer = Customer::findCustomerInfo($id)->one();
        if (!$customer)
        {
            return false;
        }


        $this->id = $id;
        $this->person_id = $customer->person->id;
        $this->firstname = $customer->person->firstname;
        $this->lastname = $customer->person->lastname;
        $this->middlename = $customer->person->middlename;
        $this->fullname = $this->lastname . ' ' .
            (!empty($this->middlename)? $this->middlename  . ' ':""). $this->firstname;
        $this->gender = $customer->person->gender;
        $this->birthdate = StringUtils::DateFormatConverter($customer->person->birthdate, "Y-m-d", "d/m/Y");
        $this->ssn = $customer->person->ssn;
        $this->email = $customer->person->email;
        $this->phone_number = $customer->person->phone_number;

        $this->company_id = $customer->company->id;

        $address = Address::getCurrentAddress($this->person_id);

        if ($address)
        {
            $this->address_id = $address->id;
            $this->house_number = $address->house_number;
            $this->street = $address->street;
            $this->ward_id = $address->ward_id;
            $this->district_id = $address->district_id;
            $this->province_id = $address->province_id;
            $this->phone = $address->phone;

            $this->loadWardList();

        }


        return true;
    }

    public function attributeLabels(){
        return [
            'firstname' => 'Tên',
            'middlename'    => 'Tên đệm',
            'lastname' => 'Họ',
            'fullname'  => 'Họ tên',
            'gender'    => 'Phái',
            'birthdate' => 'Ngày sinh',
            'ssn'       => 'CMND/Passport',
            'phone_number'  => 'SĐT',
            'house_number'  => 'Số nhà',
            'street'    => 'Tên đường',
            'ward_id'  => 'Phường/Xã',
            'district_id'  => 'Quận/Huyện',
            'province_id'      => 'Tỉnh/TP',
            'email' => 'Email',
            'area'  => 'Khu vực',
            'company_id'    => 'Đơn vị công tác'

        ];
    }


    public function getDistrictList($province_id = null){
        if ($province_id){
            $districtList = District::find()->select(['district.id', 'district.name'])
                ->innerJoin("province", "district.province_id = province.id")
                ->where(['district.province_id' => $province_id])

                ->orderBy(['name' => 'ACS'])->all();
        }else{
            $districtList = District::find()->select(['id', 'name'])->orderBy(['name' => 'ACS'])->all();

        }
        $districtList= ArrayHelper::map($districtList, 'id', 'name');

        return $districtList;
    }

    public function update()
    {
        $params = Yii::$app->request->post();
        $request = Yii::$app->request;



        $customer_id = $request->post("customer_id");

        $customerForm = new CustomerForm();
        $customerForm->attributes = $params;
        $customerForm->id = $customer_id;

        $customer = new Customer();
        $customer = $customer->getCustomer($customerForm->id);

       /* if (!$this->validate())
        {
            return false;
        }*/

        if (!$customer)
        {
            return false;
        }

        $person = Person::findOne(["id" => $customer->person_id]);
        $names = StringUtils::SplitName($request->post("fullname"));

        $person->firstname  = $names['firstname'];
        $person->lastname = $names['lastname'];
        $person->middlename = $names['middlename'];


        $person->gender = $request->post("gender");
        $person->birthdate = StringUtils::DateFormatConverter($request->post("birthdate"), "d/m/Y", "Y-m-d");
        $person->email = $request->post("email");
        $person->phone_number = preg_replace('/[^0-9]/', '', $request->post("phone_number"));
        $person->ssn = $request->post("ssn");
        //$person->updated_at = date("Y-m-d H:i:s");

        $transaction = Yii::$app->db->beginTransaction();
        if (!$person->save()) {
            $transaction->rollBack();

            return false;
        }


        $address = new Address();
        $address->attributes = $params;

        $address->person_id = $customer->person_id;
        $address->phone = $request->post("phone_number");
        $address->ward_id = $request->post("ward_id");
        $address->district_id = (int) $request->post("district_id");


        $address->findProvinceID();
        $address->created_at = date("Y-m-d H:i:s");


        if (! $address->isEmpty())
        {
            if ( ! $address->save() )
            {
                $transaction->rollBack();
                return false;
            }

            $address->updateCurrentAddress();
            $address->is_current = 1;
            $address->save();
        }

        if (!$customer->save()) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();


        return true;

    }

    public function save(){

        $params = Yii::$app->request->post();
        $request = Yii::$app->request;
        $person = new Person();
        $person->attributes = $params;

        $names = StringUtils::SplitName($request->post("fullname"));
        $person->firstname  = $names['firstname'];
        $person->lastname = $names['lastname'];
        $person->middlename = $names['middlename'];

        $person->phone_number = preg_replace('/[^0-9]/', '', $person->phone_number);

        $person->birthdate = StringUtils::DateFormatConverter($request->post("birthdate"), "d/m/Y", "Y-m-d");

        $person->ssn = $request->post("ssn");
        $person->created_at = date("Y-m-d H:i:s");


        $address = new Address();
        $address->attributes = $params;
        $address->district_id = (int) $request->post("area");
        $address->findProvinceID();
        $address->phone = $person->phone_number;
        $address->created_at = date("Y-m-d H:i:s");
        $address->is_current = 1;

        $customer = new Customer();


        $this->person = $person;
        $this->address = $address;

        $transaction = Yii::$app->db->beginTransaction();

        if (!$person->save()) {
            $transaction->rollBack();
            return false;
        }



        $address->person_id = $person->id;
        $customer->person_id = $person->id;
        $customer->company_id = $request->post("company_id");

        if (! $address->isEmpty())
        {
            if ( ! $address->save() )
            {
                $transaction->rollBack();
                return false;
            }
        }


        // save customer
        if (!$customer->save()) {
            $transaction->rollBack();
            return false;
        }
        $this->id = $customer->id;

        $transaction->commit();

        return true;

    }

    public function loadWardList()
    {
        $out = Ward::find()->select(['ward.id', 'ward.name'])
            ->innerJoin("district", "district.id = ward.district_id")
            ->where(['district.id' => $this->district_id ])
            ->orderBy(['name' => 'ACS'])->all();

        $wardList = ArrayHelper::map($out, "id", "name");
        $this->wardList = $wardList;
    }




}
