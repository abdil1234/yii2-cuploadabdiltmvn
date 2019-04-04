<?php

namespace abdiltmvn\Cupload;
use abdiltmvn\Cupload\UploadInterface;
use Yii;
use abdiltmvn\Cupload\helper\UploadHelper;
use abdiltmvn\Cupload\UploadedFileModel;
use yii\web\UploadedFile;
use yii\bootstrap\ActiveForm;

/**
 * This is just an example.
 */
class ServerUpload implements UploadInterface
{
    
    public $path = null;

    public $attributes = 'file';

    public $status = false;

    public $dataUpload = [];

    public $pesan = "Data Berhasil masuk";

    public function uploadServer()
    {

        $data = Yii::$app->request->post();
        $upload = new UploadHelper();
        $mdmUpload = new UploadedFileModel();

        $file = UploadedFile::getInstanceByName($this->attributes);
        $pesan = null;

        if($file){
            $upload->filename = md5(microtime() . $file->name);
            $upload->file = $file;
        }

        $fields = [$this->attributes];
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();

        try{
            if(Yii::$app->api->validateFormData($data, $fields)  && $upload->upload()){
                $filename = Yii::getAlias($this->path.$upload->filename.'.'. $upload->file->extension);
                $mdmUpload->name = $file->name;
                $mdmUpload->filename = $filename;
                $mdmUpload->name = $file->name;
                $mdmUpload->size = $file->size;
                $mdmUpload->type = $file->type;
                $mdmUpload->save();

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
