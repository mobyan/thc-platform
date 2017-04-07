<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static $table_map = [
        'config' => 'device_config',
        'data' => 'device_data',
        'user' => 'users',
        'apply' => 'user_apply',
        'download' => 'download_jobs',
    ];

    static $sys_root_models = ['user', 'app', 'apply', 'role'];
    static $app_root_models = [\App\Station::class];

    static $permissions = [];

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('auth.resource');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function _index($where = null, $callback = null)
    {
        $this->assertPermissions('index');
        if (in_array(static::$model, static::$app_root_models)) {
            $where = ['app_id', '=', $this->user()->app_id];
        }
        $limit = Request::input('limit', 20);
        $offset = Request::input('offset', 0);
        $with = Request::input('with');
        if ($where === null) {
            $where = [DB::raw('1'), 1];
        }
        $items = call_user_func_array([static::$model, 'where'], $where)->limit($limit)->offset($offset);
        if ($with) {
            if (str_contains($with,',')) {
                $with = explode(',', $with);
            }
            $items = $items->with($with);
        }
        if ($callback) {
            $callback($items);
        }
        $items = $items->get();
        $count = count($items);
        return compact('count', 'items');
    }

    public function _show($id) {
        $this->assertPermissions('show');
        $model = static::$model;
        $with = Request::input('with');
        if ($with) {
            $model = call_user_func([$model, 'with'], $with);
        }
        return call_user_func([$model, 'find'], $id);
    }

    public function _update($id, $data) {
        $this->assertPermissions('update');
        $model = call_user_func([static::$model, 'find'], $id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function _store($data) {
        $this->assertPermissions('store');
        return call_user_func([static::$model, 'create'], $data);
    }

    public function _destroy($id) {
        $this->assertPermissions('destroy');
        $model = call_user_func([static::$model, 'find'], $id);
        if(is_null($model)) {
            return null;
        }
        $model->delete();
        return $model;
    }

    public function view($file, $data=null) {
        return view($file, ['tplData' => $data]);
    }

    public function assertPermissions($action) {
        if (!empty(static::$permissions)) {
            $permissions = isset(static::$permissions[$action]) ? static::$permissions[$action]: @static::$permissions['all'];
            if (!$permissions) return;
            $this->user()->allows($permissions, false, $this->user()->app_id?:0) || \App::abort(403);
        }
    }

    public function schema() {
        return (new static::$model)->schema();
    }

    public function user() {
        return Request::instance()->user();
    }
}
