<?php

namespace atms\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;


/**
 * This is the model class for table "customer_request".
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
 * @property string $processed_at
 *
 * @property User $assignedTo
 * @property User $processedBy
 * @property Airport $fromAirport
 * @property Airport $toAirport
 * @property Customer $customer
 * @property TicketClass $ticketClass
 * @property User $creator
 */
class CustomerRequestForm extends Model
{

    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $creator_id;
    /**
     * @var
     */
    public $customer_id;
    /**
     * @var
     */
    public $from_airport;
    /**
     * @var
     */
    public $to_airport;
    /**
     * @var
     */
    public $ticket_class_id;
    /**
     * @var
     */
    public $departure;
    /**
     * @var
     */
    public $return;
    /**
     * @var
     */
    public $note;
    /**
     * @var
     */
    public $status;
    /**
     * @var
     */
    public $created_at;
    /**
     * @var
     */
    public $checked;
    /**
     * @var
     */
    public $processed_by;
    /**
     * @var
     */
    public $assigned_to;
    /**
     * @var
     */
    public $adult;
    /**
     * @var
     */
    public $children;
    /**
     * @var
     */
    public $infant;
    /**
     * @var
     */
    public $deleted;
    /**
     * @var
     */
    public $processed_at;


    public $airportList;

    public $ticketClassList;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_request';
    }

    public function init()
    {

        parent::init();

        $this->loadAirportList();


    }

    public function loadAirportList()
    {
        $list = Airport::getAirportList();
        $this->airportList =  ArrayHelper::map($list,
            "code",
            function ($model, $defaultValue) {
                return $model['code'] . ' - ' . $model['name'] . ' - ' . $model['city'] ;
            }
        );

        $list = TicketClass::find()->select(['id', 'class'])->orderBy(["class" => 'ACS'])->all();

        $this->ticketClassList =  ArrayHelper::map($list, "id", "class");
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creator_id', 'customer_id', 'to_airport', 'from_airport','ticket_class_id', 'departure', 'adult'], 'required'],
            [['creator_id', 'customer_id', 'ticket_class_id', 'status', 'checked', 'processed_by', 'assigned_to', 'adult', 'children', 'infant', 'deleted'], 'integer'],
            [['departure', 'return', 'created_at', 'processed_at'], 'safe'],
            [['note'], 'string'],
            [['adult','children','infant'], 'compare', 'compareValue' => 100, 'operator' => '<', 'type' => 'number', 'message' => 'Số lượng không hợp lệ'],
            [['adult'], 'integer' , 'min' => 1, 'max' => 100, 'message' => 'Số lượng không hợp lệ'],

            [['departure', 'return'], 'date', 'skipOnEmpty' => true, 'format' => 'php:Y-m-d'],
            ['departure', 'required', 'message' => 'Cho biết ngày khởi hành.'],

            /*['departure', 'compare', 'compareAttribute' => 'return', 'operator' => '<',
                'enableClientValidation' => true,'message' => 'Ngày về không được trước ngày đi',
                'when'  => function($model){
                  return   $model->departure != null;
                }
            ],*/
            ['return', 'compare', 'compareAttribute' => 'departure', 'operator' => '>=',
                'enableClientValidation' => true,'message' => 'Ngày về không được trước ngày đi'
            ],

            //["from_airport",'checkFromToAirport'],
            //["from_airport",'each', 'rule' => ['string']],
            [['to_airport'], 'string'],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assigned_to' => 'id']],
            [['processed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['processed_by' => 'id']],
            [['from_airport'], 'exist', 'skipOnError' => true, 'targetClass' => Airport::className(), 'targetAttribute' => ['from_airport' => 'code']],
            [['to_airport'], 'exist', 'skipOnError' => true, 'targetClass' => Airport::className(), 'targetAttribute' => ['to_airport' => 'code']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['ticket_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketClass::className(), 'targetAttribute' => ['ticket_class_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    public function checkFromToAirport($attribute, $params)
    {
        if (empty($this->from_airport)) {
            $this->addError('from_airport', "Chọn hành trình cho chuyến bay");
        }elseif (!is_array($this->from_airport)) {
            $this->addError('from_airport', "Hành trình phải bao gồm điểm đi và điểm đến");
        }elseif (count($this->from_airport) != 2) {
            $this->addError('from_airport', "Phải chọn cả điểm đi và điểm đến");
        }else{
            foreach ($this->from_airport as $value) {
                if (!is_string($value) && strlen($value) > 3) {
                    $this->addError('from_airport ', "Mã sân bay không hợp lệ");
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => 'Creator ID',
            'customer_id' => 'Mã số KH',
            'from_airport' => 'Hành trình',
            'to_airport' => 'Điểm đến',
            'ticket_class_id' => 'Hạng vé',
            'departure' => 'Ngày khởi hành',
            'return' => 'Ngày về',
            'note' => 'Ghi chú',
            'status' => 'Trạng thái',
            'created_at' => 'Created At',
            'checked' => 'Checked',
            'processed_by' => 'Processed By',
            'assigned_to' => 'Assigned To',
            'adult' => 'Người lớn',
            'children' => 'Trẻ em',
            'infant' => 'Em bé',
            'deleted' => 'Deleted',
            'processed_at' => 'Processed At',

        ];
    }

    public function save()
    {

        $customerRequest = new CustomerRequest();
        $customerRequest->attributes = $this->attributes();
        $customerRequest->creator_id = $this->creator_id;
        $customerRequest->customer_id = $this->customer_id;
        $customerRequest->from_airport = $this->from_airport;
        $customerRequest->to_airport = $this->to_airport;
        $customerRequest->ticket_class_id = $this->ticket_class_id;
        $customerRequest->departure = $this->departure;
        $customerRequest->return = $this->return;
        $customerRequest->note = $this->note;
        $customerRequest->status = CustomerRequest::CUSTOMER_REQUEST_STATUS_WAITING;
       // $customerRequest->created_at = date("Y-m-d H:i:s");
        $customerRequest->checked = 0;
        $customerRequest->processed_by = null;
        $customerRequest->assigned_to = $this->assigned_to;
        $customerRequest->adult = $this->adult;
        $customerRequest->children = $this->children;
        $customerRequest->infant = $this->infant;
        $customerRequest->deleted = 0;
        $customerRequest->processed_at = null;
        /*$this->validate();
        var_dump($this->errors);
        die;*/
        if ($this->validate()){
            return $customerRequest->save();
        }else{
            return false;
        }

    }
    
    public function isEmpty()
    {
        return ( empty($this->id) && empty($this->customer_id));
    }

    public  function findCustomerRequest($id)
    {
            $customerRequest = CustomerRequest::findOne(['id' => $id]);

            if ($customerRequest)
            {
                $this->attributes   = $customerRequest->attributes();
                $this->id = $id;
                $this->creator_id   = $customerRequest->creator_id ;
                $this->customer_id  = $customerRequest->customer_id ;
                $this->from_airport = $customerRequest->from_airport ;
                $this->to_airport    = $customerRequest->to_airport;
                $this->ticket_class_id  = $customerRequest->ticket_class_id;
                $this->departure    = $customerRequest->departure ;
                $this->return       = $customerRequest->return;
                $this->note         = $customerRequest->note ;
                $this->status       = $customerRequest->status;
                $this->created_at   = $customerRequest->created_at;
                $this->checked      = $customerRequest->checked;
                $this->processed_by = $customerRequest->processed_by ;
                $this->assigned_to  =   $customerRequest->assigned_to ;
                $this->adult        = $customerRequest->adult ;
                $this->children     = $customerRequest->children ;
                $this->infant       = $customerRequest->infant ;
                $this->deleted      = $customerRequest->deleted ;
                $this->processed_at = $customerRequest->processed_at;
            }

          //  $this->loadAirportList();
            return $this;
    }

}
