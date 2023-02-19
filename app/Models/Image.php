<?php

namespace App\Models;

use JsonSerializable;

class Image implements JsonSerializable
{


    public function __construct(private string $url, private string $bucket,
                                private string $key, private string $userId,
                                private string $name)
    {

    }

    public static function createFromArray(array $array): Image
    {
        $object = new static("", "", "", "", "");
        foreach ($array as $key => $value) {
            if ($object->$key === "") {
                $object->$key = $value;
            }
        }
        return $object;
    }


    public function getUrl(): string
    {
        return $this->url;
    }

    public function getBucket(): string
    {
        return $this->bucket;
    }

    public function getKey(): string
    {
        return $this->key.$this->userId."-".$this->name;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
