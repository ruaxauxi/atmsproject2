<?php

namespace atms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use atms\models\Customer;
use yii\helpers\ArrayHelper;

/**
 * CustomerSearch represents the model behind the search form about `atms\models\Customer`.
 */
class CustomerSearch extends Customer
{
    public $province_id;
    public $district_id;
    public $name;
    public $phone_number;
    public $id;
    public $sort_by;

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

        $query = Customer::findCustomersInfo();

        // add conditions that should always apply here



        $this->load($params);

        $this->id = isset($params['id'])?trim($params['id']):null;
        $this->district_id = isset($params['district_id'])?trim($params['district_id']):null;
        $this->province_id = isset($params['province_id'])?trim($params['province_id']):null;
        $this->name = isset($params['name'])?trim($params['name']):null;
        $this->phone_number = isset($params['phone_number'])?trim($params['phone_number']):null;



        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        var_dump($params);
        die;*/
        // grid filtering conditions
        $query->andFilterWhere([
            'customer.id' => $this->id,
            //'address.city' => $this->city,
            //'person.phone_number' => $this->phone_number,

        ]);

        if ($this->province_id){
            $query->andWhere('address.province_id =' . $this->province_id );
        }

        if ($this->district_id){
            $query->andWhere('address.district_id = ' . $this->district_id );
        }

        if ($this->phone_number){
            $query->andWhere('person.phone_number LIKE "%' . $this->phone_number .'%" ');
        }

        if ($this->name){
            $query->andWhere('person.firstname LIKE "%' . $this->name .'%" ' .
                ' OR person.middlename LIKE "%' . $this->name . '%"  ' .
                ' OR person.lastname LIKE "%' . $this->name . '%"  ' .
                ' OR CONCAT(person.lastname, " " , person.middlename , " " , person.firstname)  LIKE "%' . $this->name . '%"  '

            );
        }

/*
        var_dump($query->createCommand()->rawSql);
        die;*/
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page',20),

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
                /*'attributes' => [
                    'name' => [
                        'asc' => [
                            'author.Name' => SORT_ASC,
                            'Published' => SORT_ASC,
                            'Title' => SORT_ASC,
                        ],
                        'desc' => [
                            'author.Name' => SORT_DESC,
                            'Published' => SORT_DESC,
                            'Title' => SORT_DESC,
                        ],
                    ],
                ],*/
            ],

        ]);

        return $dataProvider;
    }
}
