<?php

namespace atms\controllers;

use atms\models\Address;
use atms\models\Company;
use atms\models\CustomerForm;
use atms\models\CustomerRequest;
use atms\models\CustomerRequests;
use atms\models\CustomerRequestCreateForm;
use atms\models\CustomerRequestCreateSearch;
use atms\models\CustomerRequestForm;
use atms\models\CustomerRequestSearch;
use atms\models\CustomerRequestsSearch;
use atms\models\District;
use atms\models\Person;
use atms\models\Province;
use atms\models\UserProfile;
use atms\models\Ward;

use common\utils\StringUtils;
use Yii;
use atms\models\Customer;
use atms\models\CustomerSearch;
use yii\helpers\ArrayHelper;
//use yii\web\Controller;
use atms\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;
use yii\filters\AccessControl;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends \atms\components\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
               // 'only' => ['login', 'logout', 'signup'],
                'rules' => [
                   /* [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],*/
                    [
                        'allow' => true,
                       // 'actions' => [''], // all actions
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionEditCustomerRequest()
    {

        $request = Yii::$app->request;
        // get customer ID by Post & GET
        $customer_id = Yii::$app->request->get('id')?Yii::$app->request->get('id'):Yii::$app->request->post('id');

        $customer = Customer::findCustomerInfo($customer_id)->one();

        if (!$customer)
        {
            return $this->render('error', [
                'model' => [],
                'title'   => 'Yêu cầu đặt vé',
                'message' => '<h2>Yêu cầu không hợp lệ</h2> Không thể tìm thấy thông tin Khách hàng có Mã <b>#' . $customer_id . ' </b>',
                'return_url' => '/customer/view-customer-requests'
            ]);
        }



        $customerRequestForm = new CustomerRequestForm();
        $customerRequestForm->customer_id = $customer->id;

        if (Yii::$app->request->isGet)
        {
            // if edit request
            $request_id  = "";
            if ($request->get("edit")){
                $request_id = $request->get("edit");
                $customerRequestForm = $customerRequestForm->findCustomerRequest($request_id);

                if (!$customerRequestForm->isEmpty())
                {
                    $customerRequestForm->departure = StringUtils::DateFormatConverter($customerRequestForm->departure, "Y-m-d", "d-m-Y");
                    $customerRequestForm->return = StringUtils::DateFormatConverter($customerRequestForm->return, "Y-m-d", "d-m-Y");
                    $airports[] = $customerRequestForm->from_airport;
                    $airports[] = $customerRequestForm->to_airport;

                    $customerRequestForm->from_airport = $airports;

                }

            }

            $searchModel = new CustomerRequestSearch();
            $params = Yii::$app->request->queryParams;
            $params['customer_id'] = $customer_id;
            $dataProvider = $searchModel->search($params);

            return $this->render("view-customer-request", [
                'model' => $customerRequestForm,
                'dataProvider' => $dataProvider,
                'customer'  => $customer,
                'request_id' => $request_id,
            ]);


        }elseif (Yii::$app->request->isPost)
        {
            $customerRequestForm->load(Yii::$app->request->post());
            $request = Yii::$app->request;

            $customerRequestForm->attributes = $request->post();

            $customerRequestForm->departure = StringUtils::DateFormatConverter($customerRequestForm->departure, "d-m-Y", "Y-m-d");
            $customerRequestForm->return = StringUtils::DateFormatConverter($customerRequestForm->return, "d-m-Y", "Y-m-d");

            $userProfile = new UserProfile();
            $userProfile = $userProfile->getUserProfile(Yii::$app->user->id);

            $customerRequestForm->creator_id = $userProfile->user_id;
            $customerRequestForm->assigned_to = $userProfile->user_id;

            $airports = $customerRequestForm->from_airport;
            if (count($airports) == 2){
                $customerRequestForm->from_airport = $airports[0];
                $customerRequestForm->to_airport = $airports[1];
            }

            if ($request->post("request_id")){
                $customerRequestForm->id = $request->post("request_id");
            }

            if ($customerRequestForm->save()) {
                return $this->redirect(['view-customer-request', 'id' => $customerRequestForm->customer_id]);
            } else {

                $customerRequestForm->load(Yii::$app->request->post());
                $customerRequestForm->attributes = $request->post();

               // $customerRequestForm->departure = StringUtils::DateFormatConverter($customerRequestForm->departure, "d-m-Y", "Y-m-d");
               // $customerRequestForm->return = StringUtils::DateFormatConverter($customerRequestForm->return, "d-m-Y", "Y-m-d");
                $searchModel = new CustomerRequestSearch();

                $params = Yii::$app->request->queryParams;
                $params['customer_id'] = $customer_id;
                $dataProvider = $searchModel->search($params);

                return $this->render('view-customer-request', [
                    'model' => $customerRequestForm,
                    'customer'  => $customer,
                    'dataProvider' => $dataProvider,
                ]);
            }
        }

    }

    public function actionViewCustomerRequest($id)
    {

        $customer = CustomerRequests::findRequestInfo($id)->one();


        if (Yii::$app->request->isAjax)
        {

            //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax("_view-customer-request", [
                'model' => $customer
            ]);

        }else{
            return $this->render("view-customer-request", [
                'model' => $customer
            ]);
        }
    }

    public function actionUpdateCustomerRequestStatus()
    {
        $request = Yii::$app->request;
        $id = $request->post("id");
        $checked = $request->post("checked");
        $customer_request = CustomerRequest::findOne(["id" => $id]);


        if ( $customer_request )
        {
            if ($request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;

                $processed_by = "";
                if ($checked == 'true'){
                    $customer_request->status = CustomerRequest::CUSTOMER_REQUEST_STATUS_CHECKED;
                    $customer_request->checked =  1;
                    $userProfile = new UserProfile();
                    $userProfile = $userProfile->getUserProfile(Yii::$app->user->id);

                    $customer_request->processed_by = $userProfile->user_id;

                    $processed_by = $userProfile->username ;

                }else{
                    $customer_request->status = CustomerRequest::CUSTOMER_REQUEST_STATUS_WAITING;
                    $customer_request->checked =  0;
                    $customer_request->processed_by = null;
                }


                $success = ($customer_request->update()?true:false);
                $icon ="";
                if ((int) $customer_request->status == \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_WAITING || $customer_request->status == null )
                {
                    $icon =    "<i class='fa fa-clock-o request-status tooltipster-borderless pointer' title='Chờ xử lý'></i>";
                }else if ((int) $customer_request->status == \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_CHECKED )
                {
                    $icon =    "<i class='fa fa-check request-status-success tooltipster-borderless pointer' title='Đã xử lý'></i>";

                }else if( (int) $customer_request->status ==  \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_CANCELlED)
                {
                    $icon =    "<i class='fa fa-remove request-status-primary tooltipster-borderless pointer' title='Đã huỷ'></i> ";
                }else{
                    $icon =    "";
                }

                $data = [
                    'success'   => $success,
                    'icon'  => $icon,
                    'processed' => $processed_by
                ];

                return $data;

            }else{
                return $this->redirect("/customer/view-customer-request?id=" . $customer_request->customer_id);
            }
        }else{
            if ($request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return  $data = [
                    'success'   => null,
                    'icon'  => ''
                ];

            }else{
                return $this->render('error', [
                    'model' => [],
                    'title'   => 'Yêu cầu đặt vé',
                    'message' => '<h2>Yêu cầu không hợp lệ</h2>',
                    'return_url' => '/customer/view-customer-requests?id=' . $customer_request->customer_id
                ]);
            }

        }


    }

    public function actionDeleteCustomerRequest($id)
    {
        $customer_request = CustomerRequest::findOne(["id" => $id]);
        $request = Yii::$app->request;
        if ($request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $data = [];

            if ($customer_request && $customer_request->delete()){
               return  $data = [
                    'deleted'   => true
                ];
            }else{
               return  $data = [
                    'deleted'   => true
                ];
            }

        }else{

            if ($customer_request && $customer_request->delete()){

                return $this->redirect("/customer/view-customer-request?id=" . $customer_request->customer_id);

            }else{

                return $this->render('error', [
                    'model' => [],
                    'title'   => 'Yêu cầu đặt vé',
                    'message' => '<h2>Yêu cầu không hợp lệ</h2> Không thể tìm thấy thông tin Khách hàng có Mã <b>#' . $$customer_request->customer_id . ' </b>',
                    'return_url' => '/customer/view-customer-requests'
                ]);
            }

        }




    }


    /**
     * Show all customer's requests
     */
    public function actionViewCustomerRequests()
    {

        $searchModel = new CustomerRequestsSearch();

       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params['province_id'] = Yii::$app->request->post('province_id');
        $params['district_id'] = Yii::$app->request->post('district_id');
        $params['phone_number'] = Yii::$app->request->post('phone_number');
        $params['customer_id'] = Yii::$app->request->post('customer_id');
        $params['name']   = Yii::$app->request->post('name');

        $dataProvider = $searchModel->search($params);


        $provinceList = $searchModel->getProvinceList();

        $districtList = $searchModel->getDistrictList(Yii::$app->request->post('province_id',null));


        return $this->render("view-customer-requests", [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'params'    => $params,
            'provinceList' => $provinceList,
            'districtList'  => $districtList,
        ]);

    }

    public function actionCreateCustomerRequest()
    {


        $request = Yii::$app->request;
        $model = new CustomerRequestCreateForm();

        $model->load(Yii::$app->request->get());

        $searchModel = new CustomerRequestCreateSearch();

        $params['province_id'] = Yii::$app->request->get('province_id');
        $params['district_id'] = Yii::$app->request->get('district_id');
        $params['phone_number'] = Yii::$app->request->get('phone_number');
        $params['customer_id'] = Yii::$app->request->get('customer_id');
        $params['customer_name']   = Yii::$app->request->get('customer_name');

        $model->customer_name = $request->get("customer_name");
        $model->customer_id = $request->get("customer_id");
        $model->phone_number = $request->get("phone_number");

        $dataProvider = $searchModel->search($params);

        $customerForm = new CustomerForm();

        if ($request->isPost && $request->post('btnCustomerSave'))
        {
            $customerForm->load(Yii::$app->request->post());
            $request = Yii::$app->request;

            $customerForm->attributes = $request->post();
            $customerForm->request = $request;

            if ($customerForm->save()) {

                return $this->redirect(['customer/view-customer-request', 'id' => $customerForm->id]);
            }

        }


        return $this->render("create-customer-request",[
            'model' => $model,
            'dataProvider'   => $dataProvider,
            'isPost'    => $request->get('btnSearch'),
            'customerForm'  => $customerForm,

        ]);


    }

    public function actionCustomerRequestCreateNewCustomer()
    {
        $customerForm = new CustomerForm();
        if (Yii::$app->request->isGet)
        {
            return $this->render('customer-request-create-new-customer', [
                'model' => $customerForm,
            ]);

        }elseif (Yii::$app->request->isPost)
        {
            $customerForm->load(Yii::$app->request->post());
            $request = Yii::$app->request;

            $customerForm->attributes = $request->post();
            $customerForm->request = $request;

            if ($customerForm->save()) {
                return $this->redirect(['customer/view', 'id' => $customerForm->id]);
            } else {
                return $this->render('customer-create', [
                    'model' => $customerForm,
                ]);
            }
        }
    }





    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();

        $params['province_id'] = Yii::$app->request->get('province_id');
        $params['district_id'] = Yii::$app->request->get('district_id');
        $params['phone_number'] = Yii::$app->request->get('phone_number');
        $params['id'] = Yii::$app->request->get('id');
        $params['name']   = Yii::$app->request->get('name');

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $provinceList = $searchModel->getProvinceList();

        $districtList = $searchModel->getDistrictList(Yii::$app->request->get('province_id',null));
        $customerForm = new CustomerForm();
        //$customerForm->attributes = Yii::$app->request->post();
        //$customerForm->init();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params'  => $params,
            'provinceList' => $provinceList,
            'districtList'  => $districtList,
            'customerForm'  => $customerForm
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewCustomer($id)
    {


        $customer = Customer::findCustomerInfo($id)->one();


        if (Yii::$app->request->isAjax)
        {

            //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax("view-customer", [
                'model' => $customer
            ]);

        }else{
            return $this->render("view-customer", [
                'model' => $customer
            ]);
        }
    }


    public function actionCreateCustomer()
    {
        $customerForm = new CustomerForm();
        if (Yii::$app->request->isGet)
        {
            return $this->render('create-customer', [
                'model' => $customerForm,
            ]);

        }elseif (Yii::$app->request->isPost)
        {
            $customerForm->load(Yii::$app->request->post());
            $request = Yii::$app->request;

            $customerForm->attributes = $request->post();
            $customerForm->request = $request;

            if ($customerForm->save()) {
                return $this->redirect(['customer/view-customer', 'id' => $customerForm->id]);
            } else {
                return $this->render('create-customer', [
                    'model' => $customerForm,
                ]);
            }
        }
    }



    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $customerForm = new CustomerForm();


        if (Yii::$app->request->isGet){

            if (Yii::$app->request->isAjax){
                return $this->renderPartial('_customer-create', [
                    'model' => $customerForm,
                ]);
            }else{
                return $this->render('customer-create', [
                    'model' => $customerForm,
                ]);
            }
        }elseif (Yii::$app->request->isPost){
            $customerForm->load(Yii::$app->request->post());
            $request = Yii::$app->request;

            $customerForm->attributes = $request->post();
            $customerForm->request = $request;

            if ($customerForm->save()) {
                return $this->redirect(['customer/view', 'id' => $customerForm->id]);
            } else {
                return $this->render('_customer-create', [
                    'model' => $customerForm,
                ]);
            }
        }


    }*/


    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateCustomer($id)
    {
       /* $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/

        $customerForm = new CustomerForm();
        $request = Yii::$app->request;

        if ($request->isGet){

            if (! $customerForm->loadById($id))
            {
                return $this->render('error', [
                    'model' => [],
                    'title'   => 'Cập nhật Khách hàng',
                    'message' => 'Không thể tìm thấy thông tin Khách hàng có ID <b>#' . $id . ' </b>',
                    'return_url' => '/customer'
                ]);

            }else{

                return $this->render('update-customer', [
                    'model' => $customerForm
                ]);
            }

        // if form submitted
        }else{

            $customer_id = $request->post("customer_id");
            $customer = new Customer();
            $customer = $customer->getCustomer($customer_id);

            // if customer not found
            if (!$customer)
            {
                return $this->render('error', [
                    'model' => [],
                    'title'   => 'Cập nhật Khách hàng',
                    'message' => 'Không thể tìm thấy thông tin Khách hàng có ID <b>#' . $id . ' </b>',
                    'return_url' => '/customer'
                ]);
            }

            $customerForm->loadById($customer_id);

            if ($customerForm->update()) {
                return $this->redirect(['customer/view-customer', 'id' => $customerForm->id]);
            } else {
                return $this->render('update-customer', [
                    'model' => $customerForm,
                ]);
            }

       }





    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteCustomer($id)
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


    public function actionLoadDistrict() {
        $out = [];
        if (Yii::$app->request->post('depdrop_parents')) {
            $parents = Yii::$app->request->post('depdrop_parents');
            if ($parents != null) {
                $city = $parents[0];
                $out = District::find()->select(['district.id', 'district.name'])
                    ->innerJoin("province", "district.province_id = province.id")
                    ->where(['province.id' => $city ])
                    ->orderBy(['name' => 'ACS'])->all();

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionLoadWard() {
        $out = [];
        if (Yii::$app->request->post('depdrop_parents')) {
            $parents = Yii::$app->request->post('depdrop_parents');
            if ($parents != null) {
                $district = $parents[0];
                $out = Ward::find()->select(['ward.id', 'ward.name'])
                    ->innerJoin("district", "district.id = ward.district_id")
                    ->where(['district.id' => $district ])
                    ->orderBy(['name' => 'ACS'])->all();

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
}
