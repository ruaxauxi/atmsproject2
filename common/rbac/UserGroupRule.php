<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by PhpStorm.
 * User: dangvo
 * Date: 7/18/17
 * Time: 12:51 PM
 */

namespace common\rbac;

use Yii;
use yii\rbac\Rule;
use common\utils\GLOBALS;

class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {

        if (!Yii::$app->user->isGuest)
        {
            $group = Yii::$app->user->identity->group;

            if ($item->name ===  GLOBALS::GROUP_ADMIN ) // ADMIN
            {
                return $group ==  GLOBALS::GROUP_ADMIN ;

            } elseif ($item->name ===  GLOBALS::GROUP_STAFF ) // STAFF
            {
                return $group == GLOBALS::GROUP_ADMIN  || $group ==  GLOBALS::GROUP_STAFF;

            }elseif ($item->name ===  GLOBALS::GROUP_COLLABORATOR ) // COLLABORATOR
            {
                return $group == GLOBALS::GROUP_ADMIN  || $group ==  GLOBALS::GROUP_STAFF || $group == GLOBALS::GROUP_COLLABORATOR;

            }elseif ($item->name ===  GLOBALS::GROUP_CUSTOMER)  // CUSTOMER
            {
                return $group == GLOBALS::GROUP_ADMIN  || $group ==  GLOBALS::GROUP_STAFF
                    || $group == GLOBALS::GROUP_COLLABORATOR || $group == GLOBALS::GROUP_CUSTOMER;

            }
        }
        return false;
    }
}