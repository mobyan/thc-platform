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
        $this->isApi = Request::is('api/*');

        $this->middleware(function ($request, $next){
            $user = Auth::user();
            $this->user = $user;
            $app_id = Request::header('X-APP-ID', Request::input('app_id'));
            if ($this->doCheckScope() && !$user->has('apps', $app_id)) {
                return abort(403);
            }
            $this->app_id = $app_id;
            return $next($request);
        });

        $ownership = Request::route()->parameters();
        if ($this->dontCheckScope()) {
            return;
        }

        $this->middleware(function ($request, $next) use ($ownership) {
            $this->assertRelationship($ownership);

            return $next($request);
        });

    }

    public function doCheckScope() {
        $ownership = Request::route()->parameters();
        $root_model = 'App\\'.ucfirst(explode('/', Request::path())[1]);
        return in_array($root_model, static::$app_root_models);
    }

    public function dontCheckScope() {
        $ownership = Request::route()->parameters();
        if (count($ownership) === 1 && in_array(array_keys($ownership)[0], static::$sys_root_models)) return true;
        if (in_array(explode('/', Request::path())[1], static::$sys_root_models)) return true;
        return false;
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
            $where = ['app_id', '=', $this->app_id];
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

    public function assertRelationship($stack) {

        if ($this->app_id == null) {
            throw new \Exception("No App ID", 1);   
        }
        // check scope
        // if (!$user->hasRole(['super', 'admin'])) {
        $stack = array_merge(['app' => $this->app_id], $stack);
        // }
        if (empty($stack)) return;
        $tmp = [];
        foreach ($stack as $k => $v) {
            $tmp[@static::$table_map[$k]? : $k] = $v;
        }
        $stack = $tmp;

        $tables = array_keys($stack);
        $where = [];
        for ($i=0; $i < count($tables) - 1; $i++) { 
            $a = $tables[$i];
            $b = $tables[$i + 1];
            $where[] = "{$a}.id = {$b}.{$a}_id";
        }
        foreach ($stack as $k => $v) {
            $where[] = "{$k}.id = {$v}";
        }
        $where_str = implode(' and ', $where);
        $from = implode(', ', $tables);
        $sql = "select count(*) as cnt from {$from} where {$where_str};";
        $statment = DB::getPDO()->prepare($sql);
        $statment->execute();
        $ret = $statment->fetchAll();
        $cnt = $ret[0]['cnt'];
        if ($cnt != 1) {
            throw new \Exception("Resource Not Found", 1);
        }
    }

    public function view($file, $data=null) {
        return view($file, ['tplData' => $data]);
    }

    public function assertPermissions($action) {
        if (!empty(static::$permissions)) {
            $permissions = isset(static::$permissions[$action]) ? static::$permissions[$action]: @static::$permissions['all'];
            if (!$permissions) return;
            call_user_func_array('\Entrust::can', $permissions) || \App::abort(403);
        }
    }

    public function schema() {
        return (new static::$model)->schema();
    }
}
