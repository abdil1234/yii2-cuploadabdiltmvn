Upload a file accros different hosts
===========================
purpose for upload file throught different hosts

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist abdilltmvn/yii2-cuploadabdiltmvn "*"
```

or add

```
"abdilltmvn/yii2-cuploadabdiltmvn": "*"
```

to the require section of your `composer.json` file.


USAGE : 
-----
### client side
```
use abdiltmvn\Cupload\ClientUpload;

$upload = new ClientUpload([
    'attr' => 'file',
    'url' => 'http://url.test/backend/site/upload',
    'path' => Yii::getAlias("@common/uploads/file.pdf")
]);

return $upload->uploadClient()->data; //return array data
``` 
### server side
use abdiltmvn\Cupload\ServerUpload;

$serverUpload = new ServerUpload();

return [
    'dataUpload' => $data->uploadServer()
]; // return array data 

 TODO
-----

 -  Add more documentacion 