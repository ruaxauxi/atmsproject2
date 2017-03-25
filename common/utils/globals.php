<?php
namespace common\dell;
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by PhpStorm.
 * User: dangvo
 * Date: 3/12/17
 * Time: 8:55 AM
 */

/**
 * Interface UserStatus
 * @var INACTIVE = 0; // user deleted their account by themselves
 * @var DISABLED = 1;  // user is disabled by admins
 * @var UNAPPROVED = 2;  // use registered but have not verified yet
 * @var VERIFIED = 3;  // user verified by admin or by themselves  via email
 * @var ACTIVE = 10 ; // user is working
 * @var DELETED = 20; // user is deleted
 */
interface UserStatus{
    const INACTIVE = 0; // user deleted their account by themselves
    const  DISABLED = 1;  // user is disabled by admins
    const UNAPPROVED = 2;  // use registered but have not verified yet
    const VERIFIED = 3;  // user verified by admin or by themselves  via email
    const ACTIVE = 10 ; // user is working
    const DELETED = 20; // user is deleted
}


interface UserType{
    const ADMIN = 1;
    const STAFF =2;
    const COLLABORATOR = 3;
    const RETAIL_CUSTOMER = 4;
    const PREFERRED_CUSTOMER = 5;
}

interface PassengerType{
    const ADULT = 1;
    const CHILD = 2;
    const BABY  = 3;
}

interface TicketStatus{
    const BOOKED = 1;
    const AVAILABLE = 2;
    const RESERVED = 3;
}

interface TicketDetailStatus{
    const NORMAL = 0;
    const RETURNED = 1;
    const CANCELLED = 2;

}

interface Gender{
    const MALE = 0;
    const FEMALE = 1;
}