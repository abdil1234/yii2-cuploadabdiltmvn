<?php

namespace abdiltmvn\Cupload;
use Yii;
use yii\web\UploadedFile;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

use abdiltmvn\Cupload\UploadServerInterface;
use abdiltmvn\Cupload\models\UploadedFileModel;
use abdiltmvn\Cupload\helper\UploadHelper;

/**
 * This is just an example.
 */
class ServerUpload implements UploadServerInterface
{
    /**
     * @var string 
     * current Db connection that usage as store data file to database 
     */

    public $db = "db";

    /**
     * @var boolean
     * whether a file store to $db
     */
    public $save = true;
    
    /**
     * @var string
     */
    public $path = "@common/upload/";

    /**
     * @var string
     * Attributes @default value file
     */

    public $attributes = 'file';

    /**
     * @var boolean
     * Status of the file was uploaded
     */

    public $status = false;

    /**
     * @var array
     * Array of file information
     */

    private $dataUpload = [];

    /**
     * @var string
     * Message when an upload was success
     */

    private $pesan = "Data Berhasil masuk";


    public function uploadServer()
    {

        $data = Yii::$app->request->post();
        $upload = new UploadHelper();

        $file = UploadedFile::getInstanceByName($this->attributes);
        $pesan = null;
        $id_file = null;

        if($file){
            $upload->filename = md5(microtime() . $file->name);
            $upload->file = $file;
            $upload->folderPath = $this->path;
        }

        $fields = [$this->attributes];

        if($upload->upload()){
            $filename = Yii::getAlias($this->path.$upload->filename.'.'. $upload->file->extension);
            
            $this->status = true;
            $this->dataUpload = $file;
            $this->path = $filename;

            $pesan = $this->pesan;
            
            if($this->save){
                $id_file = $this->saveToDb();
            }

        }else{
            $pesan = ActiveForm::validate($upload);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'status' =>  $this->status,
            'data' => $this->dataUpload,
            'pesan' => $pesan,
            'path' => $this->path,
            'id_file' => $id_file
        ]; 
    }

    protected function saveToDb() : int {

        $mdmUpload = new UploadedFileModel();
        $mdmUpload->name = $this->dataUpload->name;
        $mdmUpload->filename = $this->path;
        $mdmUpload->name = $this->dataUpload->name;
        $mdmUpload->size = $this->dataUpload->size;
        $mdmUpload->type = $this->dataUpload->type;
        $mdmUpload->save();

        return $mdmUpload->id;

    }
}
