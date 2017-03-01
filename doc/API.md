# API 文档
## 概述
系统较为严格遵循RESTful风格实现了数据接口，通过这些接口可以方便的对资源进行增删查改操作。

## 资源定位
资源定位通过URI进行，基本形式为`/{resource_name}/{resource_id}`，例如`/station/123`定位`id`为`123`的`station`资源。并且可以通过嵌套的方式表达资源的从属关系，例如`/station/123/device/456/config/789`。

## 资源表征
使用JSON表征数据。
```
{
    "id": 218,
    "device_id": 32,
    "data": "{\"t_30\": {\"unit\": 88}}",
    "control": "{\"t_30\": {\"value\": 123}}",
    "updated_at": "2017-01-15 11:00:46",
    "created_at": "2017-01-15 11:00:46",
    "deleted_at": null
}
```

## 资源鉴权
鉴权流程： 
1. 获取登录状态 
2. 获取用户scope(APP)
3. 连表查询确定资源从属关系并且顶级资源属于用户scope（super, admin资源不验证scope）
4. 验证用户的角色有操作资源的权限（super, admin资源不验证权限）

## 资源操作
使用HTTP Method表达对资源的CRUD操作：
* 查询列表：GET /{resource_name}
* 查询资源：GET /{resource_name}/{resource_id}
* 创建资源：POST /{resource_name}
* 更新资源：PUT /{resource_name}/{resource_id}
* 删除资源：DELETE /{resource_name}/{resource_id}

## 资源
* station
* device
* config
* data

## 列表
```
Route::resource('station', 'StationController', ['only' => [
    'index', 'show', 'store', 'update', 'destroy'
]]);    
Route::resource('station/{station}/device', 'DeviceController', ['only' => [
    'index', 'show', 'store', 'update', 'destroy'
]]);
Route::resource('station/{station}/device/{device}/data', 'DeviceDataController', ['only' => [
    'index'
]]);
Route::resource('station/{station}/device/{device}/config', 'DeviceConfigController', ['only' => [
    'index', 'show', 'store', 'update', 'destroy'
]])
```

## 示例
```
获取config列表：
curl -X GET  'http://120.77.34.29/api/station/1/device/3/config'
返回：
{
    "count": 1,
    "items": [{
        "id": 13,
        "device_id": 3,
        "config": "{\"t_10\": {\"desc\": \"10depth temperature\", \"port\": \"AD2\", \"type\": \"temperature\", \"unit\": \"x\"}, \"t_30\": {\"desc\": \"30depth temperature\", \"port\": \"AD1\", \"type\": \"temperature\", \"unit\": \"x\"}}",
        "control": "{\"img_upload_invl\": \"*\/30 * * * *\", \"data_upload_invl\": \"*\/30 * * * *\", \"img_capture_invl\": \"*\/30 * * * *\", \"data_capture_invl\": \"*\/30 * * * *\"}",
        "updated_at": "2017-01-14 18:52:20",
        "created_at": "2017-01-14 18:52:20",
        "deleted_at": null
    }]
}

获取config信息：
curl -X GET  'http://120.77.34.29/api/station/1/device/3/config/13'
返回：
{
    xxx
    ...
}

创建config:
curl -X POST 'http://120.77.34.29/api/station/1/device/3/config' -d '{"control": ..., "data": ...}'
返回:
{
    id: xxx,
    xxx,
    ...
}

更新config
curl -X PUT 'http://120.77.34.29/api/station/1/device/3/config/13' -d '{"control": ..., "data": ...}'
返回:
{
    id: xxx,
    xxx,
    ...
}

删除config
curl -X DELETE 'http://120.77.34.29/api/station/1/device/3/config/13'
返回:
无
```