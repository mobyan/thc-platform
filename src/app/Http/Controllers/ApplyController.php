<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\UserApply;

class ApplyController extends Controller {

    static $model = '\App\UserApply';

    static $permissions = [
        'all' => ['sys_r'],
        'update' => ['sys_w'],
        'store' => [],
        'pass' => ['sys_w'],
    ];

    /**
     * pass operation
     * @param  string $id apply id
     * @return object     apply info
     */
    public function pass($id) {
        $apply = UserApply::find($id);
        $user = User::find($apply->user_id);

        !$user->has('roles', $apply->role_id) && $user->roles()->attach([$apply->role_id]);
        // !$user->has('apps', $apply->app_id) && $user->apps()->attach([$apply->app_id]);
        $user->app_id = $apply->app_id;
        $user->save();
        
        $apply->status = 'pass';
        $apply->save();
        return $apply;
    }

    /**
     * unpass operation
     * @param  string $id apply id
     * @return object     apply info
     */
    public function unpass($id) {
        $apply = UserApply::find($id);
        $apply->status = 'unpass';
        $apply->save();
        return $apply;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->_index(['status', 'pending']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $req request
     * @return Response
     */
    public function store(Request $req)
    {
        $body = $req->all();
        $body['user_id'] = $req->user()->id;
        return $this->_store($body);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
