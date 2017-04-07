<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserType
 *
 * @author dang vo <vhdang2302@gmail.com>
 */
namespace common\utils;
use common\utils\Enum;

class UserType extends Enum {
     
    const ADMIN = 1;
    const STAFF =2;
    const COLLABORATOR = 3;
    const COSTUMER = 4;
   
}
