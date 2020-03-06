<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Thing;
use Illuminate\Http\Request;
use Upyun\Config;
use Upyun\Upyun;

class ThingController extends Controller
{
    public $client;

    public function __construct()
    {
        $serviceConfig = new Config(env('CDN_SERVICE_NAME'), env('CDN_OPERATOR_NAME'), env('CDN_OPERATOR_PASSWORD'));
        $this->client = new Upyun($serviceConfig);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function love()
    {
        $path = __FUNCTION__;
        $data = $this->client->read($path, null, []);

        $fileAddSrc = array_map(function (&$file) use ($path) {
            $file['src'] = env('CDN_URL')."/{$path}/{$file['name']}";

            return $file;
        }, $data['files']);
        $data['files'] = $fileAddSrc;

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $key = 'love';

        if (false === $request->hasFile($key)) {
            return response()->json('没有文件');
        }
        if (false === $request->file($key)->isValid()) {
            return response()->json('上传失败');
        }

        $filename = $request->file($key)->getClientOriginalName();

        // 放到又拍云
        $file = fopen($request->file($key), 'r');

        return $this->client->write($key.'/'.$filename, $file);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Thing $thing)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Thing $thing)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thing $thing)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thing $thing)
    {
    }
}
