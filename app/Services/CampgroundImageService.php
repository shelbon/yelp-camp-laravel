<?php

namespace App\Services;

use App\Models\Image;
use App\S3\S3Uploader;
use Aws\Result;
use Aws\S3\S3ClientInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class CampgroundImageService
{
    private S3Uploader $S3Uploader;
    private  S3ClientInterface $client;

    public function __construct(S3Uploader $S3Uploader, S3ClientInterface $client)
    {

        $this->S3Uploader = $S3Uploader;
        $this->client = $client;
    }

    public function upload(UploadedFile $file, $bucket, $key): ?Result
    {
        return $this->S3Uploader->upload($file, $bucket, $key);
    }

    public function delete(Image $image): ?Result
    {
        try {
            $result = $this->client->deleteObject(array(
                'Bucket' => $image?->getBucket(),
                'Key' => $image?->getKey()));
        } catch (Aws\S3\Exception\S3Exception $e) {
            \Debugbar::addMessage("There was an error deleting the file.\n");
            throw ValidationException::withMessages([
                "image" => $e->getMessage()
            ]);
        }
        return $result;
    }
}
