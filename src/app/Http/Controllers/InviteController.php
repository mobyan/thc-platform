<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InviteController extends Controller
{
    //static $model = \Junaidnasir\Larainvite\Models\LaraInviteModel::class;

    /*static $permissions = [
    'all' => ['sys_r'],
    'update' => ['sys_w'],
    'store' => ['sys_w'],
    'index' => [],
  ];*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user()->invitations;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $email = $request->input('email');
        $app_id = $this->user()->app_id;
        $regioncode = $request->input('regioncode');
        $refCode = Invite::invite($email, $this->user()->id, Carbon::now()->addYear(1),
        function(/* InvitationModel, see Configurations */ $invitation) use ($app_id, $regioncode) {
          $invitation->app_id = $app_id;
          $invitation->regioncode = $regioncode;
          }
        );

        //send email
        $data = ['email'=>$email, 'code'=>$refCode, 'name'=> '用户']
        Mail::send('invite',$data, function($message)use($data){
          $message->to($data['email'], $data['name'])->subject('welcome to THC');
        });


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $this->_show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            ]);
        $data = $request->all();
        $data['app_id'] = $request->user()->app_id;
        return $this->_update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->_destroy($id);
    }
}
