<?php

namespace App\Utils;

use OSS\OssClient;
use OSS\Core\OssException;

class Oss
{
    protected $ossClient;
    protected $bucket;

    public function __construct()
    {
        $this->bucket = env('BUCKET');

        try {
            $this->ossClient = new OssClient(env('ACCESS_KEY_ID'), env('ACCESS_KEY_SECRET'), env('ENDPOINT'));
        } catch (OssException $e) {
            print $e->getMessage();
        }
    }

    public function put($object, $content)
    {
        try {
            $result = $this->ossClient->putObject($this->bucket, $object, $content);
        } catch (OssException $e) {
            print $e->getMessage();
        }

        return $result;
    }

    public function get($object)
    {
        try {
            $result = $this->ossClient->getObject($this->bucket, $object);
        } catch (OssException $e) {
            print $e->getMessage();
        }

        return $result;
    }

    public function del($object)
    {
        try {
            $result = $this->ossClient->deleteObject($this->bucket, $object);
        } catch (OssException $e) {
            print $e->getMessage();
        }

        return $result;
    }

    public function exist($object)
    {
        try {
            $result = $this->ossClient->doesObjectExist($this->bucket, $object);
        } catch (OssException $e) {
            print $e->getMessage();
        }

        return $result;
    }
}
