<?php

namespace common\utility;

use common\models\Image;
use yii\web\UploadedFile;

class FsHelper
{

    /**
     * Save UploadedFile.
     * ! Important: This function uploads this model filename to keep consistency of the model.
     * 
     * @param UploadedFile $file Uploaded file to save
     * @param string $attribute Attribute name where the uploaded filename name will be saved
     * @param string $fileName Name which file will be saved. If empty will use the name from $file
     * @param bool $autoExtension `true` to automatically append or replace the extension to the file name. Default is `true`
     * 
     * @return void
     */
    public static function saveUploadedFile(UploadedFile $file, $fullpath, $fileName = '', $autoExtension = true)
    {
        if (empty($fileName)) {
            $fileName = $file->name;
        }
        if ($autoExtension) {
            $_file = (string) pathinfo($fileName, PATHINFO_FILENAME);
            $fileName = $_file . '.' . $file->extension;
        }
        // $this->{$attribute} = $fileName;
        // if (!$this->validate($attribute)) {
        //     return;
        // }
        $filePath = $fullpath . '/' . $fileName;
        $localPath = $file->tempName;
        $handle = fopen($localPath, 'r');
        $contents = fread($handle, filesize($localPath));
        fclose($handle);
        $filesystem = \Yii::$app->get('fs');
        $filesystem->write($filesystem->normalizePath($filePath), $contents);
        return $checksum = $filesystem->checksum($filePath); // etag or md5
    }

    public static function UploadFile(UploadedFile $file, $fullpath, $name, $caption = NULL, $alt = NULL)
    {
        $_file = (string) pathinfo($file->name, PATHINFO_FILENAME);
        $filename = $_file . '_' . time() . '.' . $file->extension;
        $etag =  FsHelper::saveUploadedFile($file, $fullpath, $filename, true);
        $filemodel = new Image();
        $bytesize = $file->size;
        $extension = $file->extension;
        // list($width, $height) = getimagesize($file->tempName);
        if (in_array($extension, ['svg', 'pdf','doc','docx'])) {
            $width = 0;
            $height = 0;
        } else {
            list($width, $height) = getimagesize($file->tempName);
        }
        $filemodel->name = !empty($name) ? $name : $filename;
        $filemodel->caption = $caption;
        $filemodel->alt = $alt;
        $filemodel->extension = $extension;
        $filemodel->bytesize = $bytesize;
        $filemodel->height = $height;
        $filemodel->width = $width;
        $filemodel->filename = $filename;
        $filemodel->filepath = $fullpath . '/' . $filename;
        $filemodel->save(false);
        // $etag = FsHelper::saveUploadedFile($file, $filename = $filemodel->id . '.' . $file->extension, true);
        return $filemodel->id;
        return false;
    }

    /**
     * Delete model file attribute.
     * 
     * @param string $attribute 
     * 
     * @return void
     */
    public static function removeFile($filePath)
    {
        if (empty($filePath)) {
            return;
        }
        $filePath = $filePath;
        $filesystem = \Yii::$app->get('fs');
        return $filesystem->delete($filesystem->normalizePath($filePath));
    }

    public static function RemoveSpecialChar($str)
    {
        // Using str_replace() function
        $res = str_replace(array(
            '\'',
            '"',
            ',',
            ';',
            '<',
            '>'
        ), ' ', $str);
        return $res;
    }
}
