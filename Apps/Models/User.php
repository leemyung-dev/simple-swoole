<?php

/**
 * Created by NetBeans.
 * User : liming <liming@wutiao.com>
 * Date : 2018-10-24
 * Time : 17:39:46
 */

namespace SimpleSwoole\Apps\Models;

class User extends \SimpleSwoole\Core\Mysql {

    public function index($userId) {
        $result = $this->query("SELECT * FROM user WHERE id = {$userId}");

        return $result;
    }

}
