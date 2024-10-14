<?php

namespace App\Models;

use Throwable;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $disk = "custom";

    protected $fillable = [
        'id',
        'original_name',
        'file_name',
        'file_extension',
        'file_directory',
        'content_type',
        'is_encrypted',
        'main_module',
        'sub_module',
    ];

    public $incrementing = false;

    public function deleteSingleFile()
    {
        try {
            $full_name = $this->getFullFileName();
            if(Storage::disk($this->disk)->exists($full_name)){
                $res = Storage::disk($this->disk)->delete($full_name);
                if($res) {
                    self::delete();
                    return true;
                }
                return false;
            }else{
                logger("FILE DO NOT EXIST FOR => ".$full_name."  with files id of ".$this->id);
                return false;
            }
            return false;
        } catch (Throwable $e) {
            logger($e);
            return false;
        }
    }

    public function showFile()
    {
        $Content = $this->decryptFile();
        return Response::make($Content, 200, [
          'Content-Type'        => $this->content_type,
          'Content-Disposition' => 'inline;'
        ]);
    }

    public function downloadFile($fileName)
    {
        $headers  = array(
            "Content-Type: $this->content_type",
        );
        return response()->streamDownload(function () {
            echo $this->decryptFile();
        }, "$fileName.$this->file_extension",$headers);

    }

    public static function uploadSingleFile($path, $file, $directory, $encrypt = 1,$mainModule = null, $subModule = null)
    {
        $fileContent = $file->get();
        $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $file_extension = $file->extension();
        $content_type = $file->getMimeType();

        // Encrypt the Content
        if ($encrypt) {
            $fileContent = encrypt($fileContent);
        }

        // $file_name = time() . '_' . $original_name;
        $file_name = Str::random(40).'-'. $original_name;
        $full_file_name = $path.'/'.$directory.'/'.$file_name.'.'.$file_extension;
        Storage::disk("custom")->put($full_file_name, $fileContent);
        $File = new File();
        return $File->create([
            'id' => Uuid::uuid4()->toString(),
            'original_name' => $original_name,
            'file_name' => $file_name,
            'file_extension' => $file_extension,
            'file_directory' => $path.'/'.$directory,
            'content_type' => $content_type,
            'is_encrypted' => $encrypt,
            'main_module' => $mainModule,
            'sub_module' => $subModule
        ])->id;
    }

    private function getFullFileName()
    {
        return $this->file_directory.'/'.$this->file_name.'.'.$this->file_extension;
    }

    public static function uploadMultipleFiles($path, $files, $directory, $encrypt = 1,$mainModule = null, $subModule = null)
    {
        $file_id_arr = array();
        foreach ((array)$files as $key => $file) {
            $file_id_arr[$key] = self::uploadSingleFile($path, $file, $directory, $encrypt,$mainModule, $subModule);
        }
        return $file_id_arr;
    }

    public function decryptFile()
    {
        $full_file_name = $this->getFullFileName();
        $Content = Storage::disk($this->disk)->get($full_file_name);
        if($this->is_encrypted){
            return decrypt($Content);
        }else{
            return $Content;
        }
    }
    public function getFileUrlAttribute()
    {
        $url = route('file_show',$this->id);
        return $url;
    }
    public function getDownloadFileUrlAttribute()
    {
        $data = route('file_down',$this->id);
        return $data;
    }
}
