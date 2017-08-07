<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

namespace atms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * CustomerSearch represents the model behind the search form about `atms\models\Customer`.
 */
class CustomerRequestCreateSearch extends Customer
{
    public $province_id;
    public $district_id;
    public $customer_name;
    public $phone_number;
    public $customer_id;
    public $sort_by;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id'], 'integer'],
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

    public function getProvinceList()
    {
        $provinceList = Province::find()->select(['id', 'name'])->orderBy(["name" => 'ACS'])->all();
        return  ArrayHelper::map($provinceList, "id", "name");
    }

    public function getDistrictList($province_id = null){
        if ($province_id){
            $districtList = District::find()->select(['district.id', 'district.name'])
                ->innerJoin("province", "district.province_id = province.id")
                ->where(['district.province_id' => $province_id])

                ->orderBy(['name' => 'ACS'])->all();
        }else{
            $districtList = District::find()->select(['id', 'name'])->orderBy(['name' => 'ACS'])->all();

        }
        $districtList= ArrayHelper::map($districtList, 'id', 'name');

        return $districtList;
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
        $this->customer_id = $params['customer_id'] ;
        $this->district_id = $params['district_id'] ;
        $this->province_id = $params['province_id'] ;
        $this->customer_name = $params['customer_name'] ;
        $this->phone_number = $params['phone_number'] ;

        if ($this->customer_id || $this->province_id || $this->district_id || $this->phone_number || $this->customer_name)
        {
            $query = Customer::findCustomersInfo();

            // add conditions that should always apply here


            $this->load($params);

            $this->customer_id = isset($params['customer_id'])?trim($params['customer_id']):null;
            $this->district_id = isset($params['district_id'])?trim($params['district_id']):null;
            $this->province_id = isset($params['province_id'])?trim($params['province_id']):null;
            $this->customer_name = isset($params['customer_name'])?trim($params['customer_name']):null;
            $this->phone_number = isset($params['phone_number'])?trim($params['phone_number']):null;

            // grid filtering conditions

            if ($this->customer_id)
            {
                $query->andFilterWhere([
                    'customer.id' => $this->customer_id,
                ]);
            }


            if ($this->province_id){
                $query->andWhere('address.province_id =' . $this->province_id );
            }

            if ($this->district_id){
                $query->andWhere('address.district_id = ' . $this->district_id );
            }

            if ($this->phone_number){
                $query->andWhere('person.phone_number LIKE "%' . $this->phone_number .'%" ');
            }

            if ($this->customer_name){
                $query->andWhere('person.firstname LIKE "%' . $this->customer_name .'%" ' .
                    ' OR person.middlename LIKE "%' . $this->customer_name . '%"  ' .
                    ' OR person.lastname LIKE "%' . $this->customer_name . '%"  ' .
                    ' OR CONCAT(person.lastname, " " , person.middlename , " " , person.firstname)  LIKE "%' . $this->customer_name . '%"  '

                );
            }

        }else{

            // return no customer
            $query = Customer::findCustomerInfo(-1);

        }



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page',15),

            ],
            'sort' => [
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

            ],

        ]);

        return $dataProvider;
    }
}
