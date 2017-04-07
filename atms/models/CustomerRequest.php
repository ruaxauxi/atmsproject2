<?php

namespace atms\models;

use Yii;

/**
 * This is the model class for table "customer_request".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $customer_id
 * @property string $from_airport
 * @property string $to_airpot
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
 *
 * @property User $assignedTo
 * @property User $processedBy
 * @property Airport $fromAirport
 * @property Airport $toAirpot
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
        return 'customer_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creator_id', 'customer_id', 'from_airport', 'to_airpot', 'ticket_class_id', 'departure', 'adult'], 'required'],
            [['creator_id', 'customer_id', 'ticket_class_id', 'status', 'checked', 'processed_by', 'assigned_to', 'adult', 'children', 'infant'], 'integer'],
            [['departure', 'return', 'created_at'], 'safe'],
            [['note'], 'string'],
            [['from_airport', 'to_airpot'], 'string', 'max' => 3],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assigned_to' => 'id']],
            [['processed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['processed_by' => 'id']],
            [['from_airport'], 'exist', 'skipOnError' => true, 'targetClass' => Airport::className(), 'targetAttribute' => ['from_airport' => 'code']],
            [['to_airpot'], 'exist', 'skipOnError' => true, 'targetClass' => Airport::className(), 'targetAttribute' => ['to_airpot' => 'code']],
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
            'to_airpot' => 'To Airpot',
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(User::className(), ['id' => 'assigned_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'processed_by']);
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
    public function getToAirpot()
    {
        return $this->hasOne(Airport::className(), ['code' => 'to_airpot']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
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

    /**
     * @inheritdoc
     * @return CustomerRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerRequestQuery(get_called_class());
    }
}
