<?php

namespace atms\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $customer_id
 * @property string $from_airport
 * @property string $to_airpot
 * @property integer $ticket_class_id
 * @property string $departure
 * @property string $return
 * @property integer $adult
 * @property integer $child
 * @property integer $infant
 * @property string $note
 * @property integer $status
 * @property string $created_at
 *
 * @property Airport $fromAirport
 * @property Airport $toAirpot
 * @property Customer $customer
 * @property TicketClass $ticketClass
 * @property User $creator
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creator_id', 'customer_id', 'from_airport', 'to_airpot', 'ticket_class_id', 'departure', 'adult'], 'required'],
            [['creator_id', 'customer_id', 'ticket_class_id', 'adult', 'child', 'infant', 'status'], 'integer'],
            [['departure', 'return', 'created_at'], 'safe'],
            [['note'], 'string'],
            [['from_airport', 'to_airpot'], 'string', 'max' => 3],
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
            'adult' => 'Adult',
            'child' => 'Child',
            'infant' => 'Infant',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

     
}
