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
    ];

    static $permissions = [];

    public function __construct() {
        $this->middleware('auth');

        $ownership = Request::route()->parameters();
        $ownership = array_merge(['app' => 1], $ownership);

        $this->isApi = Request::is('api/*');
        $this->assertOwnership($ownership);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function _index($where = null, $callback = null)
    {
        $this->assertPermissions('index');
        $limit = Request::input('limit', 20);
        $offset = Request::input('offset', 0);
        $with = Request::input('with');
        if ($where === null) {
            $where = [DB::raw('1'), 1];
        }
        $items = call_user_func_array([static::$model, 'where'], $where)->limit($limit)->offset($offset);
        if ($with) {
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


    public function assertOwnership($stack) {
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
        if (isset(static::$permissions[$action])) {
            if (Auth::user()->hasRole('super')) {
                return ;
            }
            $permissions = static::$permissions[$action];
            call_user_func_array('\Entrust::can', $permissions) || \App::abort(403);
        }
    }
}
