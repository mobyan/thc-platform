<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;
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
    static $app_root_models = [\App\Station::class, \App\User::class];

    static $permissions = [];

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('auth.resource');
    }

    //public function __construct_regioncodes($regioncode){
    //  return "regioncode like ".$regioncode."%";
    //}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function _index($where = null, $callback = null)
    {
        $whereLike = null;
        $items = null;
        $this->assertPermissions('index');
        if ($this->user()->app_id != 0 && in_array(static::$model, static::$app_root_models)) {
            $where = ['app_id', '=', $this->user()->app_id];
            $code = Request::input('code');
            Log::info("requestcode".$code);
            if(!$code){
                // Log::info($this->user()->code_id);
                $code = \App\Code::find($this->user()->code_id)->code;
                Log::info($code);
            }
            $whereLike = 'code like "'.$code.'%"';
            //$whereLike = isset($whereLike)? $whereLike.' or regioncode like "'.$code.'%"':'regioncode like "'.$code.'%"';

            Log::info("where is ".$whereLike);
            //$wherelike = ['regioncode', ];
        }
        if ($where === null) {
            $where = [DB::raw('1'), 1];
        }
        $items = call_user_func_array([static::$model, 'where'], $where);
        if ($whereLike){
          $items = $items->whereRaw($whereLike);
        }

        if (Request::has('sort')) {
            list($sortCol, $sortDir) = explode('|', Request::input(sort));
            $items = $items->orderBy($sortCol, $sortDir);
        } else {
            $items = $items->orderBy('id', 'asc');
            //$items = call_user_func_array([static::$model,'orderBy'],array('id', 'asc'));
        }
        $perPage = Request::input('per_page',null);
        //$limit = Request::input('limit', 20);
        //$offset = Request::input('offset', 0);
        $with = Request::input('with');



        if ($with) {
            if (str_contains($with,',')) {
                $with = explode(',', $with);
            }
            $items = $items->with($with);
        }
        if ($callback) {
            $callback($items);
        }
        if($perPage){
          $items = $items->paginate($perPage);
          return $items;
        }
        else{
          return $items->get();
        }
        //$count = count($items);

        //return response()->json($items)->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Methods', 'GET');
    }

    public function _show($id) {
        $this->assertPermissions('show');
        $model = static::$model;
        $with = Request::input('with');
        if ($with) {
            if (str_contains($with,',')) {
                $with = explode(',', $with);
            }
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
            $this->user()->allows($permissions, false) || \App::abort(403);
        }
    }

    public function schema() {
        return (new static::$model)->schema();
    }

    public function user() {
        return Request::instance()->user();
    }
}
