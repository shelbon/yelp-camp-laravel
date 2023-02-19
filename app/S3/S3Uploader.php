<?php

namespace App\S3;


use Aws\S3\S3ClientInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class S3Uploader
{

    private S3ClientInterface $client;

    public function __construct(S3ClientInterface $client)
    {
        $this->client = $client;
    }

    public function upload(UploadedFile $file, $bucket, $key): ?\Aws\Result
    {
        $result = null;
        if (!$file && !$bucket && !$key) {
            throw new \InvalidArgumentException("You must provide a file or bucket and key");
        }
        try {
            $result = $this->client->putObject(array(
                'Bucket' => $bucket,
                'Key' =>$key . Auth::user()?->getId() ."-". $file->getClientOriginalName(),
                'SourceFile' => $file->path(),
                'ACL' => 'public-read'));
        } catch (Aws\S3\Exception\S3Exception $e) {
            \Debugbar::addMessage("There was an error uploading the file.\n");

        }
        return $result;
    }


}
