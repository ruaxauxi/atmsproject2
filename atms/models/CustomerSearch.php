<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by PhpStorm.
 * User: dangvo
 * Date: 4/7/17
 * Time: 4:03 PM
 */

namespace atms\models;


class CustomerSearch extends Customer
{


    public function search($params)
    {
        $query = Customer::find();
    }

}