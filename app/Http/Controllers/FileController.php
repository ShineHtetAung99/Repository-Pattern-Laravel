<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function showFile($fileId)
    {
        $file =  File::find($fileId);
        return $file->showFile();
    }
    public function downFile($fileId)
    {
        $file =  File::find($fileId);
        $fileName = $file->original_name ? $file->original_name : $file->file_name;
        return $file->downloadFile($fileName);
    }
    public function deleteFile($fileId)
    {
        try {
            $res = delete_file_from_disk($fileId); #call file delete helper method 
            if($res) {
                return response()->json([
                    'code'    =>  200,
                    'message'   =>  trans('successMessage.SS_003'),
                ],200);
            }else{
                return response()->json([
                    'code'    =>  500,
                    'message'   =>  trans('errorMessage.SE_012'),
                ],200);
            }

        } catch (Throwable $th) {
            logger($th->getMessage());
            return response()->json([
                'code'    =>  500,
                'message'   =>  trans('errorMessage.SE_005'),
            ],500);
        }
    }
}