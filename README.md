Upload a file on different hosts
===========================
Yii2 extension that purpose for upload file throught different hosts ( *`particulary for my ordinary task XD; `* )

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
Once the extension is installed.
Prepare required table by execute yii migrate.

```
yii migrate --migrationPath=@abdiltmvn/Cupload/migrations
```

### client side
```php
use abdiltmvn\Cupload\ClientUpload;

$upload = new ClientUpload([
    'attr' => 'file',
    'url' => 'http://url.test/backend/site/upload',
    'path' => Yii::getAlias("@common/uploads/file.pdf")
]);

Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

return $upload->uploadClient()->data; //return json data
``` 
### server side

``` php
use abdiltmvn\Cupload\ServerUpload;

$serverUpload = new ServerUpload();

Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

return [
    'dataUpload' => $serverUpload->uploadServer()
]; // return json data 
```

 TODO
-----

 -  Add more documentation 
 - Release to stable version ( *`still experimental`* )