<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $ownership = Request::route()->parameters();
        $ownership = array_merge(['app_id' => 1], $ownership);
        if (is_numeric(last(Request::segments()))) {
            $ownership = array_slice($ownership, 0, count($ownership) - 1);
        }
        $this->assertOwnership($ownership);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function _index($where, $callback = null)
    {
        $limit = Request::input('limit', 20);
        $offset = Request::input('offset', 0);
        $items = call_user_func_array([static::$model, 'where'], $where)->limit($limit)->offset($offset);
        if ($callback) {
            $callback($items);
        }
        $items = $items->get();
        $count = count($items);
        return compact('count', 'items');
    }

    public function _show($id) {
        return call_user_func([static::$model, 'find'], $id);
    }


    public function assertOwnership($stack) {
        $tmp = [];
        foreach ($stack as $k => $v) {
            $tmp[substr($k, 0, strlen($k)-3)] = $v;
        }
        $stack = $tmp;
        $tables = array_keys($stack);
        // die(json_encode($stack));

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
            throw new \Exception("Resouce Not Found", 1);
        }
    }

}
