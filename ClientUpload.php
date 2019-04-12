<?php

namespace abdiltmvn\Cupload;
use yii\httpclient\Client;

/**
 * This is just an example.
 */
class ClientUpload implements UploadClientInterface
{
    public $attribute;

    public $url;

    public $pathfile;


    public function __construct($dataUpload) {
        
        $this->attribute = $dataUpload['attr'];
        $this->url = $dataUpload['url'];
        $this->pathfile = $dataUpload['path'];

        $this->uploadClient();
    }

    public function uploadClient(){
        $http = new Client();

        $upload = $http->createRequest()
        ->setMethod('POST')
        ->setUrl($this->url)
        ->addFile($this->attribute, $this->pathfile)
        ->send();

        return $upload;
    }
}
