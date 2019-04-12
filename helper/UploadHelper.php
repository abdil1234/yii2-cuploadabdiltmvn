<?php
namespace abdiltmvn\Cupload\helper;

use yii\base\Model;
use yii\helpers\FileHelper;

class UploadHelper extends Model
{
    
    public $file;

    public $filename;

    public $folderPath;

    protected $dir;

    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpeg, jpg, pdf','maxSize' => 5120000],
        ];
    }
    
    public function upload()
    {
        if ($this->validate() && $this->createUploadFolder()) {
            $this->dir = \Yii::getAlias($this->folderPath);
            $this->file->saveAs($this->dir . $this->filename . '.' . $this->file->extension, false);
            return true;
        } else {
            return false;
        }
    }

    private function createUploadFolder() : bool{
        return FileHelper::createDirectory(\Yii::getAlias($this->folderPath), $mode = 0775, $recursive = true);
    }
}