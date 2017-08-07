<?php

namespace atms\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "customer_request".
 *
 * @property integer $id
 * @property string $customer_name
 * @property string $phone_number

 */
class CustomerRequestCreateForm extends Model
{


    public $customer_id;
    public $customer_name;
    public $phone_number;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id'], 'integer'],
            [['customer_name'], 'string', 'max' => 100],
            ['phone_number', 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'customer_id' => 'MSKH',
            'customer_name' => "Họ Tên KH",
            'phone_number'  => 'Số ĐT'
        ];
    }

    public function findCustomer()
    {

    }

}
