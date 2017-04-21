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

        $query = CustomerRequest::findRequestsInfo();

        // add conditions that should always apply here



        $this->load($params);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page',20),

            ],
            /*'sort' => [
                'defaultOrder' => [
                    //    'person_id' => SORT_DESC,
                    //    'id' => SORT_ASC,
                ],
                'attributes' =>[
                    'fullName' =>[
                        'asc' => [
                            'person.lastname' => SORT_ASC
                        ],
                        'desc' => [
                            'person.lastname'   => SORT_ASC
                        ],
                        'default' => SORT_ASC
                    ],
                    'firstName' => [
                        'asc' => [
                            'person.firstname' => SORT_ASC
                        ],
                        'desc' => [
                            'person.firstname'  => SORT_DESC
                        ],
                        'default' => SORT_ASC
                    ],
                    'addressProvince' => [
                        'asc' => [
                            'address.province' => SORT_ASC
                        ],
                        'desc' => [
                            'address.province'  => SORT_DESC
                        ],
                        'default' => SORT_ASC
                    ],
                    'addressDistrict' => [
                        'asc' => [
                            'address.province' => SORT_ASC,
                            'address.district' => SORT_ASC
                        ],
                        'desc' => [
                            'address.province'  => SORT_DESC,
                            'address.district'  => SORT_DESC,
                        ],
                        'default' => SORT_ASC
                    ]
                ]

            ],*/

        ]);

        return $dataProvider;
    }
}
