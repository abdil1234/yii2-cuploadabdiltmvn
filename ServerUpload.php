<?php

namespace abdiltmvn\Cupload;
use abdiltmvn\Cupload\UploadServerInterface;
use Yii;
use abdiltmvn\Cupload\helper\UploadHelper;
use yii\web\UploadedFile;
use yii\bootstrap\ActiveForm;

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

        if($file){
            $upload->filename = md5(microtime() . $file->name);
            $upload->file = $file;
            $upload->folderPath = $this->path;
        }

        $fields = [$this->attributes];
        $connection = Yii::$app->{$db};
        $transaction = $connection->beginTransaction();

        try{
            if(Yii::$app->api->validateFormData($data, $fields)  && $upload->upload()){
                $filename = Yii::getAlias($this->path.$upload->filename.'.'. $upload->file->extension);
                
                $this->status = true;
                $this->dataUpload = $model;
                $this->path = $filename;

                $pesan = $this->pesan;

                $transaction->commit();
                
                
            }else{
                $pesan = ActiveForm::validate($upload);
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
    
            return [
                'status' =>  $this->status,
                'data' => $this->dataUpload,
                'pesan' => $pesan,
                'path' => $this->path
            ]; 

        }catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
