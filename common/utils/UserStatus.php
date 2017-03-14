<?php

namespace common\utils;

use common\utils\Enum;

/**
 * Interface UserStatus
 * @var INACTIVE = 0; // user deleted their account by themselves
 * @var DISABLED = 1;  // user is disabled by admins
 * @var UNAPPROVED = 2;  // use registered but have not verified yet
 * @var VERIFIED = 3;  // user verified by admin or by themselves  via email
 * @var ACTIVE = 10 ; // user is working
 * @var DELETED = 20; // user is deleted
 */
class UserStatus extends Enum{
    const INACTIVE = 0; // user deleted their account by themselves
    const  DISABLED = 1;  // user is disabled by admins
    const UNAPPROVED = 2;  // use registered but have not verified yet
    const VERIFIED = 3;  // user verified by admin or by themselves  via email
    const ACTIVE = 10 ; // user is working
    const DELETED = 20; // user is deleted
}
