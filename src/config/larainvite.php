<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Invitation Expiration Default
    |--------------------------------------------------------------------------
    |
    | Default Expiry time in Hours from current time.
    | i.e now() + expires (hours)
    |
    */
    'expires' => 48,

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    */
    'UserModel' => 'App\User',

    /*
    |--------------------------------------------------------------------------
    | Invitation Model
    |--------------------------------------------------------------------------
    */
    //'InvitationModel' => 'Junaidnasir\Larainvite\Models\LaraInviteModel'
    'InvitationModel' => 'App\Invitation'

];
