<?php
namespace thrift\demo;
error_reporting(E_ALL);
$GLOBALS['THRIFT_ROOT'] = '../lib';# 指定库目录，可以是绝对路径或是相对路径 
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/ClassLoader/ThriftClassLoader.php';

use Thrift\ClassLoader\ThriftClassLoader;

$GEN_DIR = realpath(dirname(__FILE__).'/..').'/gen-php';

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', $GLOBALS['THRIFT_ROOT']);# 加载thrift
$loader->registerDefinition('thrift\demo', $GEN_DIR);# 加载自己写的thrift文件编译的类文件和数据定义
$loader->register();

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements. See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership. The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;
use Thrift\Transport\TFramedTransport; 

function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());     
    return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);  
}

try {

    $socket = new TSocket('127.0.0.1', 8080); # 建立socket 
    $socket->setDebug(TRUE); 

    $transport = new TFramedTransport($socket); #这个要和服务器使用的一致 
    $protocol = new TBinaryProtocol($transport);
    $transport->open();


    $client = new RpcServiceClient($protocol);

    for($i=0; $i<1000; $i++) {
        $param = array();
        $param['name'] = "qinerg";
        $param['passwd'] = "123456";
        $result = $client->FunCall(getMillisecond(), "login", $param);

        echo "PHPClient Call->".implode('',$result)."<br>";
    }
    
    $transport->close();

} catch (TException $tx) {
    print 'TException: '.$tx->getMessage()."\n";
}

?>