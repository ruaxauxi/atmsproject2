<?php

namespace atms\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $person_id
 * @property integer $employee_type
 *
 * @property Person $person
 * @property User $user
 */
class Employee extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'person_id', 'employee_type'], 'required'],
            [['user_id', 'person_id', 'employee_type'], 'integer'],
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
            'employee_type' => 'Employee Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return PersonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonQuery(get_called_class());
    }
    
    public function getUserID()
    {
        return $this->user_id;
    }
    
    public function getPersonID()
    {
        return $this->person_id;
    }
    
    public function getEmployeeType()
    {
        return $this->employee_type;
    }
    
    /**
     * @inheritdoc
     */
    public static function getEmployeeByUserID($user_id) {
        return static::findOne(['user_id' => $user_id]);
    }
}
