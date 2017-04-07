<?php

namespace atms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\utils\VARS;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $status
 * @property string $avatar
 * @property integer usertype
 * @property datetime $last_login
 * @property integer $last_updated
 * @property string $created_at
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_INACTIVE = 0; // user deleted their account by themselves
    const STATUS_DISABLED = 1;  // user is disabled by admins
    const STATUS_UNAPPROVED = 2;  // use registered but have not verified yet
    const STATUS_VERIFIED = 3;  // user verified by admin or by themselves  via email
    const STATUS_ACTIVE = 4 ; // user is working
    const STATUS_DELETED = 5; // user is deleted

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    public $email;

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'last_updated'],
                    //ActiveRecord::EVENT_BEFORE_UPDATE => ['last_updated'],
                ],
                
                'createdAtAttribute' => 'created_at',
                //'updatedAtAttribute' => 'last_updated',
                //'value' => new Expression('NOW()'),
                'value'     => date("Y-m-d H:i:s"),
            // if you're using datetime instead of UNIX timestamp:
            // 'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['status', 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_DELETED, static::STATUS_DISABLED,
                static::STATUS_INACTIVE, static::STATUS_UNAPPROVED,static::STATUS_VERIFIED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }
    
    public function getUserID()
    {
        return isset($this->id)?$this->id:null;
    }
    
    public function getUsername()
    {
        return isset($this->username)?$this->username:null;
    }

     /**
     * 
     * @return type string return created date in d-m-Y H:M:S format
     */
    public function getCreatedAt()
    {
         if ( isset($this->created_at))
        {
             //return $this->created_at;
            return  \DateTime::createFromFormat("Y-m-d H:i:s", $this->created_at)->format("d-m-Y H:i:s");
        }else{
            return null;
        }
    }
    
    /**
     * 
     * @return type string return updated date in d-m-Y H:M:S format
     */
    public function getLastUpdated()
    {
         if ( isset($this->updated_at))
        {
            return  \DateTime::createFromFormat("Y-m-d H:i:s", $this->last_updated)->format("d-m-Y H:i:s");
        }else{
            return null;
        }
    }
    
    /**
     * 
     * @return type string return updated date in d-m-Y H:M:S format
     */
    public function getLastLogin()
    {
         if (isset($this->last_login))
        {
            return  \DateTime::createFromFormat("Y-m-d H:i:s", $this->last_login)->format("d-m-Y H:i:s");
        }else{
            return null;
        }
    }
    
    public function updateLastLogin()
    {
        $this->last_login = date("Y-m-d H:i:s", time());
         $this->save();
    }
    
    /**
     * @inheritdoc
     */
    public static function getUserByID($id) {
        return static::findOne(['id' => $id]);
    }
    
}
