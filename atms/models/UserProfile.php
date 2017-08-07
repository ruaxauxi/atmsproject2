<?php

namespace atms\models;

use Yii;
use atms\models\User;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $status
 * @property string $email
 * @property string $avatar
 * @property integer $usertype
 * @property string $last_login
 * @property string $created_at
 * @property string $last_updated
 

 
 * @property string $updated_at

 * 
 * 
 * 
 * @property integer $user_id
 * @property integer $person_id
 * @property integer $employee_type
 * 
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property boolean $gender
 * @property string $birthdate

 */
class UserProfile extends \yii\base\Model
{

    /**
     * @var
     */
    public $user_id;
    /**
     * @var
     */
    public $employee_id;
    /**
     * @var
     */
    public $person_id;

    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $created_at;
    /**
     * @var
     */
    public $last_updated;
    /**
     * @var
     */
    public $status;
    /**
     * @var
     */
    public $last_login;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $avatar;
    /**
     * @var
     */
    public $usertype;

    /**
     * @var
     */
    public $employee_type;


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
    public $fullname;
    /**
     * @var
     */
    public $sex;
  
        private  $_user;
        private $_employee;
        private $_person;


        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['username'], 'required'],
            [['status', 'usertype'], 'integer'],
            [['username'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50],
            [['username'], 'unique'],

            [['user_id', 'person_id', 'employee_id', 'employee_type'], 'integer'],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            
            [['lastname'], 'required'],
            [['gender'], 'boolean'],          
            [['firstname', 'middlename', 'lastname'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID',
            'username' => 'Tên đăng nhập',
            'password_hash' => 'Mât khẩu',
            'created_at' => 'Thời điểm tạo',           
            'status' => 'Trạng thái',         
            'email' => 'Email',
            'avatar' => 'Avatar',
            'usertype' => 'Loại tài khoản',
        ];
    }
    
    public function getUserProfile($user_id)
    {
        $this->user_id = $user_id;
        $this->_user = $this->getUser();

        if ($this->_user){
                $this->username = $this->_user->username;
                $this->created_at = $this->_user->getCreatedAt();
                $this->last_updated = $this->_user->getLastUpdated();
                $this->status = $this->_user->status;
                $this->last_login= $this->_user->getLastLogin();
               // $this->email = $this->_user->email;
                $this->avatar =  $this->_user->avatar;
                $this->usertype = $this->_user->usertype;

                $employee = $this->getEmployee();


                if ($employee){
                    $this->employee_id = $employee->id;
                    $this->employee_type = $employee->employee_type;
                    $this->person_id = $employee->person_id;

                    $person = $this->getPerson();

                    
                    if ($person){
                        $this->firstname = $person->firstname;
                        $this->middlename = $person->middlename;
                        $this->lastname = $person->lastname;
                        $this->gender = $person->gender;
                        $this->birthdate = $person->birthdate;
                        $this->fullname = $person->getFullname();
                        $this->sex = $person->getSex();
                   }
         }

        }
        return $this;

    }
    
    
    public function getUserProfileByUsername($username)
    {
        
        $this->_user = $this->getUserByUsername($username);
        
        //$this->user_id = $user_id;
        //$this->_user = $this->getUser();
        
        if ($this->_user){
                $this->username = $this->_user->username;
                $this->created_at = $this->_user->getCreatedAt();
                $this->last_updated = $this->_user->getLastUpdated();
                $this->status = $this->_user->status;
                $this->last_login= $this->_user->getLastLogin();
                $this->email = $this->_user->email;
                $this->avatar =  $this->_user->avatar;
                $this->usertype = $this->_user->usertype;

                $employee = $this->getEmployee();

                if ($employee){
                    $this->employee_id = $employee->id;
                    $this->employee_type = $employee->employee_type;
                    $this->person_id = $employee->person_id;

                    $person = $this->getPerson();

                    
                    if ($person){
                        $this->firstname = $person->firstname;
                        $this->middlename = $person->middlename;
                        $this->lastname = $person->lastname;
                        $this->gender = $person->gender;
                        $this->birthdate = $person->birthdate;
                        $this->fullname = $person->getFullname();
                        $this->sex = $person->getSex();
                   }
         }

            
        }
       
        
        
    }

    public function getPerson()
    {
        return Person::getPersonByID($this->person_id);
    }

    public function getEmployee()
    {
        return Employee::getEmployeeByUserID($this->user_id);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return User::findOne(['id' => $this->user_id]);
         
    }
    
    public function getUserByUsername($username){
        return User::findByUsername($username);
    }
    
    public function getFullname()
    {
        return $this->fullname;
    }
    
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getGender()
    {
        return ($this->gender == Person::PERSON_MALE ? "male" : "female");
    }
}
