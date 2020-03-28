<?php


use OSS\OssClient;
use OSS\Core\OssException;

class Helpers
{
    const bucket = 'antic-lab';

    /**
     * Get an OSSClient instance according to config.
     *
     * @return OssClient An OssClient instance
     */
    public static function getOssClient()
    {
        try {
            $ossClient = new OssClient(env('ACCESS_KEY_ID'), env('ACCESS_KEY_SECRET'), env('ENDPOINT'), false);
        } catch (OssException $e) {
            printf(__FUNCTION__."creating OssClient instance: FAILED\n");
            printf($e->getMessage()."\n");
            return null;
        }
        return $ossClient;
    }

    public static function getBucketName()
    {
        return self::bucket;
    }

    /**
     * A tool function which creates a bucket and exists the process if there are exceptions
     */
    public static function createBucket()
    {
        $ossClient = self::getOssClient();
        if (is_null($ossClient)) {
            exit(1);
        }
        $bucket = self::getBucketName();
        $acl = OssClient::OSS_ACL_TYPE_PUBLIC_READ;
        try {
            $ossClient->createBucket($bucket, $acl);
        } catch (OssException $e) {

            $message = $e->getMessage();
            if (\OSS\Core\OssUtil::startsWith($message, 'http status: 403')) {
                echo "Please Check your AccessKeyId and AccessKeySecret"."\n";
                exit(0);
            } elseif (strpos($message, "BucketAlreadyExists") !== false) {
                echo "Bucket already exists. Please check whether the bucket belongs to you, or it was visited with correct endpoint. "."\n";
                exit(0);
            }
            printf(__FUNCTION__.": FAILED\n");
            printf($e->getMessage()."\n");
            return;
        }
        print(__FUNCTION__.": OK"."\n");
    }

    public static function println($message)
    {
        if (!empty($message)) {
            echo strval($message)."\n";
        }
    }
}
