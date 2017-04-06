<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DownloadJob extends Model
{
    use SoftDeletes;

    protected $table = 'download_jobs';

    protected $fillable = [
        'url', 'options', 'status'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
