namespace go thrift.demo
namespace php thrift.demo

service RpcService {
    list<string> funCall(1:i64 callTime, 2:string funcCode, 3:map<string, string> paramMap),
}