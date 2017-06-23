<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TomLingham\Searchy\Facades\Searchy;

class CodeController extends Controller
{
    //
    static $model = \App\Code::class;
    static $permissions = [
    'search' => ['sys_w'],
    'index' =>['sys_w']

    ];
    public function index(Request $req)
    {

        return $this->_index();
    }

    public function search(Request $request){
      $this->assertPermissions('search');
      $content = $request->input('content')? $request->input('content'):'';
      $items = Searchy::codes("merged_name")->query("$content")->getQuery()->limit(5)->get();
      $count = count($items);
      return compact('count', 'items');
    }
}
