<?php

namespace atms\models;

use Yii;
use atms\models\Customer;
use atms\models\Employee;

/**
 * This is the model class for table "{{%customer_request}}".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $customer_id
 * @property string $from_airport
 * @property string $to_airport
 * @property integer $ticket_class_id
 * @property string $departure
 * @property string $return
 * @property string $note
 * @property integer $status
 * @property string $created_at
 * @property integer $checked
 * @property integer $processed_by
 * @property integer $assigned_to
 * @property integer $adult
 * @property integer $children
 * @property integer $infant
 * @property integer $deleted
 *
 * @property User $assignedTo
 * @property User $processedBy
 * @property Airport $fromAirport
 * @property Airport $toAirport
 * @property Customer $customer
 * @property TicketClass $ticketClass
 * @property User $creator
 */
class CustomerRequest extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer_request}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creator_id', 'customer_id', 'from_airport', 'to_airport', 'ticket_class_id', 'departure', 'adult'], 'required'],
            [['creator_id', 'customer_id', 'ticket_class_id', 'status', 'checked', 'processed_by', 'assigned_to', 'adult', 'children', 'infant', 'deleted'], 'integer'],
            [['departure', 'return', 'created_at'], 'safe'],
            [['note'], 'string'],
            [['from_airport', 'to_airport'], 'string', 'max' => 3],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assigned_to' => 'id']],
            [['processed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['processed_by' => 'id']],
            [['from_airport'], 'exist', 'skipOnError' => true, 'targetClass' => Airport::className(), 'targetAttribute' => ['from_airport' => 'code']],
            [['to_airport'], 'exist', 'skipOnError' => true, 'targetClass' => Airport::className(), 'targetAttribute' => ['to_airport' => 'code']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['ticket_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketClass::className(), 'targetAttribute' => ['ticket_class_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => 'Creator ID',
            'customer_id' => 'Customer ID',
            'from_airport' => 'From Airport',
            'to_airport' => 'To Airport',
            'ticket_class_id' => 'Ticket Class ID',
            'departure' => 'Departure',
            'return' => 'Return',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created At',
            'checked' => 'Checked',
            'processed_by' => 'Processed By',
            'assigned_to' => 'Assigned To',
            'adult' => 'Adult',
            'children' => 'Children',
            'infant' => 'Infant',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(User::className(), ['id' => 'assigned_to']);
    }
    public function getExaminerInfo()
    {
        return $this->hasOne(Employee::className(),['person_id' => 'assigned_to'])
            ->innerJoin("person", 'person.id = employee.person_id')
            ->innerJoin("user", "employee.user_id = user.id")
            ->select(" user.username, person.firstname, person.lastname, person.middlename, 
             person.gender, person.birthdate, person.email, person.phone_number,person.ssn");
    }

    public function getExaminerFullname()
    {
        $a[] = $this->examinerInfo->lastname;
        $a[] = $this->examinerInfo->middlename;
        $a[] = $this->examinerInfo->firstname;

        return implode(" ", array_filter($a));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'processed_by']);
    }

    public function getHandlerInfo()
    {
        return $this->hasOne(Employee::className(),['person_id' => 'processed_by'])
            ->innerJoin("person", 'person.id = employee.person_id')
            ->innerJoin("user", "employee.user_id = user.id")
            ->select(" user.username, person.firstname, person.lastname, person.middlename, 
             person.gender, person.birthdate, person.email, person.phone_number,person.ssn");
    }

    public function getHandlerFullname()
    {
        if (! isset($this->handlerInfo)){
            return null;
        }
        $a[] = $this->handlerInfo->lastname;
        $a[] = $this->handlerInfo->middlename;
        $a[] = $this->handlerInfo->firstname;

        return implode(" ", array_filter($a));
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromAirport()
    {
        return $this->hasOne(Airport::className(), ['code' => 'from_airport']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToAirport()
    {
        return $this->hasOne(Airport::className(), ['code' => 'to_airport']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getCustomerInfo()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id'])
            ->innerJoin("person", "person.id = customer.person_id")
            ->leftJoin("company","company.id = customer.company_id")
            ->select('customer.id, user_id, person_id, company_id, person.firstname, person.lastname, person.middlename, 
             person.gender as gender, person.birthdate, person.email, person.phone_number,person.ssn, company.company as company');

    }

    public function getCustomerFullname()
    {
        $a[] = $this->customerInfo->lastname;
        $a[] = $this->customerInfo->middlename;
        $a[] = $this->customerInfo->firstname;

         return implode(" ", array_filter($a));
    }

    public function getCustomerCompanyName(){
        if (! isset($this->customerInfo)){
            return null;
        }

        return $this->customerInfo->company;
    }

    public function getCustomerGender()
    {
        return isset($this->customerInfo)?$this->customerInfo->gender:null;
    }

    public function getCustomerGenderText()
    {

        if (! isset($this->customerInfo)){
            return null;
        }

        return $this->customerInfo->gender == Person::PERSON_FEMALE?"Nữ":"Nam";

    }

    public function getCustomerGenderTextTitle()
    {

        if (! isset($this->customerInfo)){
            return null;
        }

        return $this->customerInfo->gender == Person::PERSON_FEMALE?"Cô/Chị":"Ông/Anh";

    }

    public function getCustomerGenderIcon()
    {

        if (! isset($this->customerInfo)){
            return null;
        }

        return $this->customerInfo->gender == Person::PERSON_FEMALE?"fa-female":"fa-male";

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketClass()
    {
        return $this->hasOne(TicketClass::className(), ['id' => 'ticket_class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    public function getCreatorInfo()
    {
           return $this->hasOne(Employee::className(),['person_id' => 'creator_id'])
               ->innerJoin("person", 'person.id = employee.person_id')
               ->innerJoin("user", "employee.user_id = user.id")
               ->select("user.username, person.firstname, person.lastname, person.middlename, 
             person.gender, person.birthdate, person.email, person.phone_number,person.ssn");
    }

    public function getCreatorFirstname(){
        if (!isset($this->creatorInfo)){
            return null;
        }
        return $this->creatorInfo->firstname;
    }

    public function getCreatorFullname()
    {

        $a[] = $this->creatorInfo->lastname;
        $a[] = $this->creatorInfo->middlename;
        $a[] = $this->creatorInfo->firstname;

        return implode(" ", array_filter($a));
    }



    public static function findRequestsInfo()
    {
        return static::find()->where(['deleted' => 0]);
    }

    public static function findRequestInfo($id)
    {
        return static::find()->where(['deleted' => 0, 'id' => $id]);
    }

}
