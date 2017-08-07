<?php

namespace atms\controllers;

use atms\models\Address;
use atms\models\Person;
use Yii;
use atms\models\Customer;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Customer::findCustomersInfo();
        $city = Yii::$app->request->post('city');
        if ($city){
            $query->andFilterWhere([
                'address.city'  => $city
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            //'query' => Customer::find(),
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page',25),

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
                    'addressCity' => [
                        'asc' => [
                            'address.city' => SORT_ASC
                        ],
                        'desc' => [
                            'address.city'  => SORT_DESC
                        ],
                        'default' => SORT_ASC
                    ],
                    'addressDistrict' => [
                        'asc' => [
                            'address.city' => SORT_ASC,
                            'address.district' => SORT_ASC
                        ],
                        'desc' => [
                            'address.city'  => SORT_DESC,
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

        //$dataProvider->pagination = ['defaultPageSize' => 50];




        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'city'  => $city
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewDetails($id){

        $customer = Customer::findCustomerInfo($id)->one();

        if (Yii::$app->request->isAjax)
        {

            //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax("view-detail", [
                'model' => $customer
            ]);

        }else{
            return $this->render("view-detail", [
                'model' => $customer
            ]);
        }



    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
