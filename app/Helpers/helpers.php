<?php

use App\Models\File;


/**
 * To Delete File From Disk using files table id
 * @param $fileId (the primary key of files table)
 * @return boolean
 */

if ( !function_exists('delete_file_from_disk') ) {
    function delete_file_from_disk($fileId)
    {
        $file =  File::find($fileId);
        if(!$file) {
            logger("FILE DO NOT EXIST FOR => ".$fileId);
            return false;
        }
        $result = $file->deleteSingleFile();
        if($result) {
            return true;
        }else{
            logger("FILE DELETE FAIL FOR => ".$fileId);
        }
    }
}