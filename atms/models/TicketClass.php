<?php

namespace atms\models;

use Yii;

/**
 * This is the model class for table "ticket_class".
 *
 * @property integer $id
 * @property string $class
 * @property string $code
 *
 * @property CustomerRequest[] $customerRequests
 * @property TicketDetail[] $ticketDetails
 */
class TicketClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['class'], 'string', 'max' => 45],
            [['code'], 'string', 'max' => 1],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class' => 'Class',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerRequests()
    {
        return $this->hasMany(CustomerRequest::className(), ['ticket_class_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketDetails()
    {
        return $this->hasMany(TicketDetail::className(), ['ticket_class_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TicketClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketClassQuery(get_called_class());
    }
}
