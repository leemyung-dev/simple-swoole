<?php

/**
 * Created by NetBeans.
 * User : liming <liming@wutiao.com>
 * Date : 2018-10-22
 * Time : 17:52:18
 */
use Swoole\Process;

error_reporting(-1);
ini_set('display_errors', 1);

$process = new Process('run');
$process->start();
swoole_set_process_name("fileread");

function getLines($file) {
    $f = fopen($file, 'r');
    try {
        while ($line = fgets($f)) {
            yield $line;
        }
    } finally {
        fclose($f);
    }
}



function run() {
    $key = '';
    $filePath = ['error.log'];
    $data = [];

    foreach ($filePath as $file) {
        foreach (getLines($file) as $n => $line) {
            //日志读取规则，自行编写
        }
    }
    
    ksort($data);
    file_put_contents('result.log', json_encode($data));
}
