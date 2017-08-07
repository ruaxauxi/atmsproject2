<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

namespace atms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use atms\models\CustomerRequest;
use yii\helpers\ArrayHelper;

/**
 * CustomerSearch represents the model behind the search form about `atms\models\Customer`.
 */
class CustomerRequestSearch extends CustomerRequest
{


   /* public $province_id;
    public $district_id;
    public $name;
    public $phone_number;
    public $id;
    public $sort_by;*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'person_id', 'deleted', 'company_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }



    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $customer_id = $params['customer_id'];

        $query = CustomerRequest::findRequestsInfoByCustomerID($customer_id);

        // add conditions that should always apply here


        $this->load($params);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page',25),

            ],


        ]);

        return $dataProvider;
    }
}
