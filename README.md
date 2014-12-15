thrift-demo
===========

1,下载thrift程序

http://www.apache.org/dyn/closer.cgi?path=/thrift/0.9.2/thrift-0.9.2.exe

2,编写thrift文件(RpcService.thrift)

namespace go thrift.demo

namespace php thrift.demo

service RpcService {

    list<string> funCall(1:i64 callTime, 2:string funcCode, 3:map<string, string> paramMap),
    
}


3,生成开发库

thrift-0.9.2.exe -r -gen go RpcService.thrift

thrift-0.9.2.exe -r -gen php RpcService.thrift


4,编写server端(server.go)


5,编写client端(client.php)

