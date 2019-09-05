<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use App\DeviceData;
use App\Device;

use App\DownloadJob;

use GuzzleHttp\Client;

use ZipArchive;

// use Upyun\Upyun;
// use Upyun\Config;

class DownloadData implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $options;

    protected $image_url_prefix;

    protected $root_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($options)
    {
        $this->options = $options;
        $this->image_url_prefix = 'http://images.thcreate.com';
        $this->root_path = storage_path().'/app/';
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $unique_key = md5(uniqid());
        $download_job = DownloadJob::find($this->options['id']);
        $folder_name = (string)($download_job->user_id).'-'.($download_job->created_at)->toDateTimeString().'-'.$unique_key;
        $folder_name = join('_', explode(' ', $folder_name));
        $folder_path = $folder_name.'/';
        Storage::makeDirectory($folder_path);
        try {
            $query_options = json_decode($this->options['options']);
            for ($i=0; $i < count($query_options->device_ids); $i++){

                $device = Device::find($query_options->device_ids[$i]);

                $image_folder_path = $folder_path.$query_options->device_ids[$i].'/';
                $csv_file_name = $device->name.'-'.($download_job->created_at)->toDateTimeString().'.csv';
                $csv_file_path = $this->root_path.$folder_path.$csv_file_name;
                $device_config_id = 0;
                $data_keys_sequence = array();

                if ($query_options->with_image) {
                    Storage::makeDirectory($image_folder_path);
                }

                $device_datas = DeviceData::where('device_id', $query_options->device_ids[$i])
                                            ->whereBetween('ts', [$query_options->start_at, $query_options->end_at])
                                            ->get();
                for ($i=0; $i < count($device_datas); $i++) {
                    // echo "3--------".memory_get_usage()."\n";
                    $is_image_data = $this->check_is_image_data($device_datas[$i]->data, $device_datas[$i]->config->data);
                    // echo "4--------".memory_get_usage()."\n";
                    if ($query_options->with_image)
                    {
                        if ($is_image_data) {
                            $client = new Client();
                            $image_url = current($device_datas[$i]->data)['value'];
                            $res = $client->request('GET', $this->image_url_prefix.$image_url);
                            $image_file_path = $image_folder_path.$device_datas[$i]->ts.'.jpg';
                            Storage::disk('local')->put($image_file_path, $res->getBody()->getContents());
                            // $image_file_path = null;
                            // $res = null;
                            // $image_url = null;
                            // $client = null;
                            unset($image_file_path);
                            unset($res);
                            unset($image_url);
                            unset($client);
                        }
                    }
                    // echo "5--------".memory_get_usage()."\n";
                    if (!$is_image_data) {
                        if ($device_datas[$i]->device_config_id != $device_config_id) {
                            $device_config_id = $device_datas[$i]->device_config_id;
                            $title_line = array();
                            $data_keys_sequence = array();
                            array_push($title_line, 'date');
                            foreach ($device_datas[$i]->config->data as $key => $value) {
								array_push($title_line, iconv("UTF-8", "GB2312//IGNORE", $value['desc']));
								// array_push($title_line, $value['desc']);
                                array_push($data_keys_sequence, $key);
                            }
                            $this->save_csv($title_line, $csv_file_path);
                            // $title_line = null;
                            // unset($title_line);
                        }
                        $this->save_csv($this->get_data($device_datas[$i], $data_keys_sequence), $csv_file_path);
                    }
                    // echo "6--------".memory_get_usage()."\n";
                    // unset($device_datas[$i]->device_config_id);
                    // unset($device_datas[$i]->ts);
                    // unset($device_datas[$i]->data);
                    unset($device_datas[$i]->config);
                    // unset($is_image_data);

                }
                // foreach ($device_datas as $device_data) {
                //     echo "3--------".memory_get_usage()."\n";
                //     $is_image_data = $this->check_is_image_data($device_data->data, $device_data->config->data);
                //     echo "4--------".memory_get_usage()."\n";
                //     if ($query_options->with_image)
                //     {
                //         if ($is_image_data) {
                //             $client = new Client();
                //             $image_url = current($device_data->data)['value'];
                //             $res = $client->request('GET', $this->image_url_prefix.$image_url);
                //             $image_file_path = $image_folder_path.$device_data->ts.'.jpg';
                //             Storage::disk('local')->put($image_file_path, $res->getBody()->getContents());
                //             unset($image_file_path);
                //             unset($res);
                //             unset($image_url);
                //             unset($client);
                //         }
                //     }
                //     echo "5--------".memory_get_usage()."\n";
                //     if (!$is_image_data) {
                //         if ($device_data->device_config_id != $device_config_id) {
                //             $device_config_id = $device_data->device_config_id;
                //             $title_line = array();
                //             $data_keys_sequence = array();
                //             array_push($title_line, 'date');
                //             foreach ($device_data->config->data as $key => $value) {
                //                 array_push($title_line, $value['desc']);
                //                 array_push($data_keys_sequence, $key);
                //             }
                //             $this->save_csv($title_line, $csv_file_path);
                //             unset($title_line);
                //         }
                //         $this->save_csv($this->get_data($device_data, $data_keys_sequence), $csv_file_path);
                //     }
                //     echo "6--------".memory_get_usage()."\n";
                //     unset($device_data->config);
                //     unset($is_image_data);
                // }
            }
            $zip = new ZipArchive();
            if ($zip->open($this->root_path.$folder_name.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE) != true) {
                die('An error occurred creating your zip file.');
            }
            $this->add_file_to_zip($this->root_path.$folder_path, $zip);
            $zip->close();

            Storage::deleteDirectory($folder_path);

            $this->push_to_upyun($this->root_path.$folder_name.'.zip', $folder_name.'.zip');

            Storage::delete($folder_name.'.zip');

            $download_job->status = 'completed';
            $download_job->url = '/'.$folder_name.'.zip';
            $download_job->save();
        } catch (\Exception $e) {
            Storage::deleteDirectory($folder_path);
            echo var_dump($e->getTrace());
            throw $e;
        }
    }

    protected function check_is_image_data($data, $config) {
        if (count($data) > 0) {
            $key = key($data);
            try {
                $type = $config[$key]['type'];
                if ($type == 'image') {
                    // $data = null;
                    // $config = null;
                    return true;
                } else {
                    // $data = null;
                    // $config = null;
                    return false;
                }
            } catch (Exception $e) {
                // $data = null;
                // $config = null;
                return false;
            }
        } else {
            // $data = null;
            // $config = null;
            return false;
        }

    }

    protected function save_csv($data, $file_name) {
        $file = fopen($file_name, 'a+');
        fputcsv($file, $data);
        fclose($file);
        // unset($file);
        return;
    }

    public function get_data($raw_data, $data_keys){
        $data_line = array();
        array_push($data_line, $raw_data->ts);
        foreach ($data_keys as $data_key) {
            try {
                $value = $raw_data->data[$data_key]['value'];
                array_push($data_line, $value);
            } catch (\Exception $e) {
                // echo "3333";
                array_push($data_line, '');
                continue;
            }
        }
        return $data_line;
    }

    public function add_file_to_zip($path, $zip){
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== false){
            if ($filename != '.' && $filename != '..') {
                if (is_dir($path.'/'.$filename)) {
                    $this->add_file_to_zip($path.'/'.$filename, $zip);
                }
                else{
                    $path_component = explode('/', $path);
                    $relative_path = $path_component[count($path_component)-1];
                    $zip->addFile($path.'/'.$filename, $relative_path.'/'.$filename);
                }
            }
        }
        @closedir($path);
    }

    public function push_to_upyun($path, $filename){
        $driver = Storage::drive('upyun');
        $file = fopen($path, 'r');
        $driver->write('/'.$filename, $file);
    }
}
