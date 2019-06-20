<?php
namespace api\models;

use yii\base\Model;
use yii\web\UploadedFile;
use common\helpers\VFileHelper;

class ShareUploadForm extends Model
{

    const UPLOAD_DIR = 'share';

    /**
    * @var UploadedFile
    */
    public $imageFile;

    private $fileName;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @param $file
     */
    private function setFile($file)
    {
        $this->fileName = $file;
    }

    /**
     * @return null|string
     */
    public function getFileUrl()
    {
        return VFileHelper::getUrlByName(self::UPLOAD_DIR, $this->fileName);
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate())
        {
            $VFileHelper = new VFileHelper;
            VFileHelper::createDir(self::UPLOAD_DIR);
            $fileName = $VFileHelper->generateFilename($this->imageFile);
            $this->imageFile->saveAs(VFileHelper::getPathWithFile(self::UPLOAD_DIR, $fileName));
            $this->fileName = $fileName;
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>