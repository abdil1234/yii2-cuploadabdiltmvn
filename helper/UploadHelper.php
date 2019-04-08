<?php
namespace abdiltmvn\Cupload;

use yii\base\Model;

class UploadHelper extends Model
{
    
    public $file;

    public $filename;

    public $folderPath;

    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpeg, jpg, pdf','maxSize' => 5120000],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $dir = \Yii::getAlias($this->folderPath);
            $this->file->saveAs($dir . $this->filename . '.' . $this->file->extension, false);
            return true;
        } else {
            return false;
        }
    }

    private function createUploadFolder(){
        
    }
}