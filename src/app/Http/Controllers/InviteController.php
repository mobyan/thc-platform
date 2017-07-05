<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Invite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Mail\Invitation;

class InviteController extends Controller
{
    static $model = \App\Invitation::class;

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
        return $this->_index(['user_id','=',$this->user()->id]);
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
        // Log::info($request->all());
        $body = $request->all();
        $email = $body['email'];
        $app_id = $this->user()->app_id;
        $regioncode = $body['regioncode'];
        $refCode = Invite::invite($email, $this->user()->id, Carbon::now()->addYear(1),
        function(/* InvitationModel, see Configurations */ $invitation) use ($app_id, $regioncode) {
          $invitation->app_id = $app_id;
          $invitation->regioncode = $regioncode;
          }
        );

        //send email
        $data = ['email'=>$email, 'code'=>$refCode, 'name'=> '用户'];
        // Mail::send('invite',$data, function($message)use($data){
        //   $message->to($data['email'], $data['name'])->subject('welcome to THC');
        // });
        Mail::to($data['email'])->send(new Invitation($data['code'], $data['email']));

        return $refCode;


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

    public function extend($id){
        $invit = static::$model::find($id);
        $invit->valid_till = Carbon::now()->addYear(1);
        $invit->save();
        return $invit;
    }
}
