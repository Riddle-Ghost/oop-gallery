<?php

namespace App\lib;

class Files {

    public function uploadFile($name) {

        //Получаем временный путь до загруженной картинки (если не загружено, он пустой)
        $file = $_FILES[$name]['tmp_name'];

        if ( !empty($file) ) {

            if ( $_FILES[$name]['size'] > 3000000 ) {

                $this->deleteFile( $_FILES[$name]['tmp_name'] );
                flash()->error(['Файл превышает 3MB!']);
                return 0;
            }
            //Получаем имя загруженного фалйла с расширением
            $fileExt = pathinfo($_FILES['picture']['name']);
            //Получучаем из названия только расширение файла
            $fileExt = $fileExt['extension'];
            
            //Прописываем новый путь и генерим рандомное название файлу
            $fileName = uniqid() . '.' . $fileExt;
            $filePath = 'uploads/' . $fileName;
            move_uploaded_file($file, $filePath);

            return ['name' => $fileName, 'extension' => $fileExt];
        }

        return 0;
    }

    public function deleteFile($path) {

        $path = realpath($path);
        
        if (file_exists($path)) {
            unlink($path);
            return 1;
        }
        return 0;
    }
    public function getPath($name) {

        $info = new \SplFileInfo($name);
        return $info->getRealPath();
    }
}