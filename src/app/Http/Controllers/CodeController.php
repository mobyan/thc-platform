<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TomLingham\Searchy\Facades\Searchy;
use Artisan;
use Illuminate\Support\Facades\Log;

class CodeController extends Controller
{
    //
    static $model = \App\Code::class;
    static $permissions = [
    'search' => ['sys_w'],
    'index' =>['sys_w'],
    'show' => ['sys_w']

    ];
    public function index(Request $req)
    {

        return $this->_index();
    }

    public function search(Request $request){
      $this->assertPermissions('search');

      $content = $request->input('content');
      Log::info($content);
      $items = Searchy::codes("merged_name")->query($content)->getQuery()->limit(5)->get();
      // $with = $request->input('with');
      //
      // if ($with) {
      //     if (str_contains($with,',')) {
      //         $with = explode(',', $with);
      //     }
      //     $items = $items->with($with);
      // }
      // $items = $items->get();

      return $items;
      //$count = count($items);
      //return compact('count', 'items');
    }

    public function subs(Request $request){
        $code = static::$model::find($this->user()->code_id);
        $items = static::$model::where('code','like',$code->code."%");
        $with = $request->input('with');
        if ($with) {
            if (str_contains($with,',')) {
                $with = explode(',', $with);
            }
            $items = $items->with($with);
        }
        return $items->get();
    }

    public function show($id, Request $req){
      $this->assertPermissions('show');
      $with = $req->input('with');
      $model = static::$model;
      $code = call_user_func([$model, 'find'], $id);
      //$code = $model->find($code_id);
      if(sizeof($code->roles()->get()) == 0){
        Artisan::call('code:roles',['code_id'=> $id]);
      }
      if ($with) {
          $model = call_user_func([$model, 'with'], $with);
      }
      return call_user_func([$model, 'find'], $id);
    }
}
