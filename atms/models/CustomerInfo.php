<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 *
 * User: dangvo
 * Date: 3/27/17
 * Time: 9:39 AM
 */

namespace atms\models;


use yii\base\Model;

class CustomerInfo extends Model
{
    /**
     * This is the model class for table "customer", "person" and "address".
     *
     * @property integer $id
     * @property integer $user_id
     * @property integer $person_id
     * @property string $contact_number
     * @property int $company_id
     * @property string $company
     * @property string $firstname
     * @property string $lastname
     * @property string $middlename
     * @property integer $gender
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
     * @property string $city
     * @property string $phone
     * @property string $address_updated_at
     * @property integer $deleted
     */

    public $id;
    public $user_id;
    public $person_id;


    public $contact_number;
    public $company_id;
    public $deleted;

    // company
    public $company;

    // person table
    public $firstname;
    public $lastname;
    public $middlename;
    public $gender;
    public $birthdate;
    public $ssn;
    public $created_at;
    public $updated_at;



    // user table (optional)
    public $username;
    public $status;
    public $email;
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
    public $city;
    public $phone;
    public $address_updated_at;
    public $address_deleted;

    public $customer;


    public function rules()
    {
        return [
            [['id', 'user_id', 'person_id', 'address_id', 'deleted','status', 'usertype', 'gender'], 'integer'],
            [['firstname','lastname', 'middlename'], 'string', 'max' => 100],
            [['ssn'], 'string', 'max' => 50],
            [["created_at", "updated_at", "last_login", "last_updated", "user_created_at", "address_updated_at"], 'safe'],
            [['username'], 'string', 'max' => 20],
            [["email"], "string", "max" => 50],
            [['avatar','company'], 'string', 'max'=>255]

        ];
    }

    public function attributeLabels()
    {
        return [

        ];

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getPersonId()
    {
        return $this->person_id;
    }

    /**
     * @param mixed $person_id
     */
    public function setPersonId($person_id)
    {
        $this->person_id = $person_id;
    }

    /**
     * @return mixed
     */
    public function getContactNumber()
    {
        return $this->contact_number;
    }

    /**
     * @param mixed $contact_number
     */
    public function setContactNumber($contact_number)
    {
        $this->contact_number = $contact_number;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }



    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @param mixed $middlename
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * @param mixed $ssn
     */
    public function setSsn($ssn)
    {
        $this->ssn = $ssn;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getUsertype()
    {
        return $this->usertype;
    }

    /**
     * @param mixed $usertype
     */
    public function setUsertype($usertype)
    {
        $this->usertype = $usertype;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * @param mixed $last_login
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
    }

    /**
     * @return mixed
     */
    public function getLastUpdated()
    {
        return $this->last_updated;
    }

    /**
     * @param mixed $last_updated
     */
    public function setLastUpdated($last_updated)
    {
        $this->last_updated = $last_updated;
    }

    /**
     * @return mixed
     */
    public function getUserCreatedAt()
    {
        return $this->user_created_at;
    }

    /**
     * @param mixed $user_created_at
     */
    public function setUserCreatedAt($user_created_at)
    {
        $this->user_created_at = $user_created_at;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * @param mixed $address_id
     */
    public function setAddressId($address_id)
    {
        $this->address_id = $address_id;
    }

    /**
     * @return mixed
     */
    public function getHouseNumber()
    {
        return $this->house_number;
    }

    /**
     * @param mixed $house_number
     */
    public function setHouseNumber($house_number)
    {
        $this->house_number = $house_number;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getWard()
    {
        return $this->ward;
    }

    /**
     * @param mixed $ward
     */
    public function setWard($ward)
    {
        $this->ward = $ward;
    }

    /**
     * @return mixed
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param mixed $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getAddressUpdatedAt()
    {
        return $this->address_updated_at;
    }

    /**
     * @param mixed $address_updated_at
     */
    public function setAddressUpdatedAt($address_updated_at)
    {
        $this->address_updated_at = $address_updated_at;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return mixed
     */
    public function getAddressDeleted()
    {
        return $this->address_deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setAddressDeleted($deleted)
    {
        $this->address_deleted = $deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @param Customer $cust
     */
    public function loadData($cust)
    {
        $this->id = $cust->id;
        $this->person_id = $cust->person_id;
        $this->user_id = $cust->user_id;
        $this->contact_number = $cust->contact_number;


        $this->customer = $cust;

        $user = $this->customer->user;

        if ($user) {
            $this->populate($this->customer->user->attributes);
            $this->user_created_at = $user->created_at;
        }

        $person = $this->customer->person;

        if ($person) {
            $this->populate($person->attributes);
        }

        $address = $person->getCurrentAddress();

        if ($address) {
            $this->populate($address->attributes);
            $this->address_deleted = $address->deleted;
        }


    }

    /*
     * Populates all attributes
     * @param array $data
     */
    function populate(Array $data = null)
    {
        if (is_array($data)) {
            $methods = get_class_methods($this);
            foreach ($data as $method => $val) {

                $pattern = "/_([a-zA-Z-0-9]+)/i";
                // capitalize the first letter lEtTER -> Letter
                $method = preg_replace_callback($pattern, function ($matches) {
                    return ucwords($matches[1]);
                }, $method);

                // remove all _ chars
                $method = preg_replace("/_/i", "", $method);

                // Capitalize first letter
                $method = ucfirst($method);
                $method = 'set' . ucfirst($method);
                if (in_array($method, $methods)) {
                    $this->$method($val);
                }
            }
        } else {
            throw new \Exception("Cannot populate data, the parameters must be an array");
        }
    }

}