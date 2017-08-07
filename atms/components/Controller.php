<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by PhpStorm.
 * User: dangvo
 * Date: 7/16/17
 * Time: 4:54 PM
 */

namespace atms\components;


use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

class Controller extends \yii\web\Controller {
    public function beforeAction($event)
    {

        if ($event->controller->action->id != 'forbidden' || $event->controller->action->id != 'error'){

            $controller = ucfirst($event->controller->id) . "Controller";
            $action = "action" . ucwords($event->controller->action->id, "-");
            $action = str_replace("-", "", $action);
            $action = $controller . "_" . $action;

          //  echo  $controller. '<br/>' . $action;
          //  die;

            if (! ( \Yii::$app->user->can($controller) || \Yii::$app->user->can($action)) )
            {
                if (\Yii::$app->getUser()->isGuest &&
                    \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl))
                {
                    $this->redirect(\Yii::$app->getUser()->loginUrl);

                }else{

                    return $this->redirect("/forbidden");
                }

            }else{

                return parent::beforeAction($event);

            }

        }
        return parent::beforeAction($event);

       // echo \Yii::$app->user->identity->getRoleName();

       // echo \Yii::$app->user->can();
       // var_dump(\Yii::$app->user);



        //echo $event->controller->action->id;

        //throw new ForbiddenHttpException("You are not allow to use this function!");

        //return parent::beforeAction($event);
    }
}