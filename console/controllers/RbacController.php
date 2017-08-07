<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by PhpStorm.
 * User: dangvo
 * Date: 7/16/17
 * Time: 7:18 AM
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // create ADMIN, STAFF, COLLABORATOR, CUSTOMER ROLES

       /* $rule = new \common\rbac\UserGroupRule();
        $auth->add($rule);

        $adminRole = $auth->createRole("ADMIN");
        $adminRole->ruleName = $rule->name;

        $staffRole = $auth->createRole("STAFF");
        $staffRole->ruleName = $rule->name;

        $collaboratorRole = $auth->createRole("COLLABORATOR");
        $collaboratorRole->ruleName = $rule->name;

        $customerRole = $auth->createRole("CUSTOMER");
        $customerRole->ruleName = $rule->name;

        // add roles
        $auth->add($adminRole);
        $auth->add($staffRole);
        $auth->add($collaboratorRole);
        $auth->add($customerRole);

        // admin is the parent of the rest
        $auth->addChild($adminRole, $staffRole);
        $auth->addChild($adminRole, $collaboratorRole);
        $auth->addChild($adminRole, $customerRole);

        // staff and collaborator is parent of customer
        $auth->addChild($staffRole, $collaboratorRole);
        $auth->addChild($staffRole, $customerRole);

        $auth->addChild($collaboratorRole, $customerRole);*/

        // assign users to role
        /*$auth->assign($adminRole, 1); // dang
        $auth->assign($staffRole, 2); // teo
        $auth->assign($collaboratorRole, 3); // thaothao
        $auth->assign($customerRole, 4); // quyen

        /*
        // create permission
        /*$viewCustomerRequestsPermission = $auth->createPermission("view-customer-requests");
        $viewCustomerRequestsPermission->description = "Xem tất cả các yêu cầu của Khách hàng";

        // add permission
        $auth->add($viewCustomerRequestsPermission);

        // user has permissions
        $auth->addChild($adminRole, $viewCustomerRequestsPermission);
        $auth->addChild($staffRole, $viewCustomerRequestsPermission);*/


       /* $p = $auth->getPermission("view-customer-requests");
        $auth->remove($p);*/

        /*// add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);*/

      /*

        $adminRole = $auth->getRole("ADMIN");

        $auth->addChild($adminRole, $customerController);
        $auth->addChild($adminRole, $viewCustomerRequests);*/

       // $adminRole = $auth->getRole("STAFF");
       // $viewCustomerRequestPermission = $auth->getPermission("actionViewCustomerRequests");

       // $auth->removeChild($adminRole, $viewCustomerRequestPermission);

       // $auth->addChild($adminRole, $viewCustomerRequestPermission);

        //$customerController = $auth->createPermission("PermissionController");
        //$viewCustomerRequests = $auth->createPermission("actionViewCustomerRequests");
        //$auth->add($customerController);
        //$auth->add($viewCustomerRequests);

       // $staffRole = $auth->getRole("STAFF");

       // $auth->addChild($staffRole, $viewCustomerRequests);

        //$action = $auth->getPermission("actionViewCustomerRequests");
       // $auth->remove($action);

        $action = $auth->createPermission("PermissionController_actionIndex");
        $auth->add($action);

        $adminRole = $auth->getRole("ADMIN");
        $auth->addChild($adminRole, $action);




    }
}