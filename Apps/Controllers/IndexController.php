<?php

/**
 * Created by NetBeans.
 * User : liming <liming@wutiao.com>
 * Date : 2018-10-9
 * Time : 20:06:03
 */

namespace SimpleSwoole\Apps\Controllers;

use SimpleSwoole\Apps\Models\User;
use SimpleSwoole\Libs\Input;
use SimpleSwoole\Libs\Common;

class IndexController extends \SimpleSwoole\Core\Controller {

    public function index() {

        return $this->success('Hellow Word!');
    }

    public function view() {
        $data = [];

        $data['id'] = Input::getInt('id', 0);
        $data['content'] = Input::getString('content', 'Hellow Word!');
        $data['ip'] = Input::getString('ip', Common::getClientIp());

        $model = new User();
        $result = $model->index($data['id']);

        if ($result) {
            return $this->success($data);
        } else {
            $this->error(600);
        }
    }

}
