<?php

/** 
* Library Amazon AWS S3 
*
* Library criada para o wrapper do S3 PHP SDK
* Author: Vlad
* 
**/

namespace Fyre\Library;

use Aws\S3\S3Client;

class s3 {

    public $client = null;
    public $config = null;

    function _set($config) {

        $this->config = $config;
    }

    /* 
        Accepts files from HTTP POST
    */

    public function upload($file_name, $file_path, $skip_name_format = false) {

        $file_name = $this->formatName($file_name, $skip_name_format);

        if ($file_name == false) {

            return false;
        }

        return $this->client()->putObject(array(
            'Bucket'        => $this->config->aws_s3_bucket_name,
            'Key'           => $file_name,
            'SourceFile'    => $file_path,
            'ContentType'   => mime_content_type($file_path)
        ));
    }

    public function delete($key) {

        return $this->client()->deleteObject([
            'Bucket'    => $this->config->aws_s3_bucket_name,
            'Key'       => $this->getKeyFromPath($key),
        ]);
    }

    public function getKeyFromPath($path) {

        // Versao https
        $path = str_replace("https://" . $this->config->aws_s3_bucket_name . ".s3." . $this->config->aws_s3_region . ".amazonaws.com/", "", $path);

        // Versao http
        $path = str_replace("http://"  . $this->config->aws_s3_bucket_name . ".s3." . $this->config->aws_s3_region . ".amazonaws.com/", "", $path);

        return $path;
    }

    private function client() {

        if ($this->client == null) {

            $this->client = new S3Client([
                'version'       => 'latest',
                'scheme'        =>'http',
                'region'        => $this->config->aws_s3_region,
                'credentials'   => [
                    'key'       => $this->config->aws_s3_key,
                    'secret'    => $this->config->aws_s3_secret,
                ],
            ]);
        }

        return $this->client;
    }

    private function formatName($name, $skip_name_format = false) {

        $extension = explode('.', $name);
        $extension = strtolower(array_pop($extension));
        
        switch($extension) {

            case "jpg":
                break;
            case "jpeg":
                break;
            case "png":
                break;
            case "gif":
                break;
            case "svg":
                break;
            case "webp":
                break;
            case "blob":
                break;

            default: 
                return false;
                break;
        }

        if ($skip_name_format) {

            return $name;
        }

        // Random big key
        return md5($name . "7485e27ee5be1424c83461944faa0201" . rand(0, 1000000)) . "." . $extension;
    }
}