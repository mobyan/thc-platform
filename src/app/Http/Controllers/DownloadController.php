<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\DownloadData;
use App\DownloadJob;
use Auth;

use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    static $model = \App\DownloadJob::class;

	static $permissions = [
		'all' => ['app_r'],
		'update' => ['app_w'],
		'store' => ['app_w'],
	];

    public function index(){
        $user = Auth::user();
        $items = $user->download_jobs;
        return compact('items');
    }

    public function store(Request $request){
    	$body = $request->all();
        $download_job = new DownloadJob;
        $download_job->user_id = Auth::user()->id;
        $download_job->url = '';
        $download_job->options = json_encode($body);
        $download_job->status = 'processing';
        $download_job->save();
        // $body['job_id'] = $download_job->id;
    	$job = new DownloadData($download_job);
    	dispatch($job);
        // return $body;
    	return;
    }

    public function destroy($id){
        $download_job = DownloadJob::find($id);
        $this->delete_file($download_job->url);
        DownloadJob::destroy($id);
    }

    protected function delete_file($url){
        $driver = Storage::drive('upyun');
        $driver->delete($url);
    }
}
