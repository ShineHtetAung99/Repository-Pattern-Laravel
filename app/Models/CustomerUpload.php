<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerUpload extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'photo'
    ];
    
    protected $hidden = ['PhotoCheck','created_at','updated_at'];

    protected $appends = ['photo_url','download_photo_url'];


    public function PhotoCheck()
    {
        return $this->hasOne(File::class,'id','photo');
    }

    public function getPhotoUrlAttribute()
    {
        if($this->PhotoCheck) {
            $fielUrl = $this->PhotoCheck->file_url;
            if(!$fielUrl) return null;
            return $fielUrl;
        }
        return null;
    }
    public function getDownloadPhotoUrlAttribute()
    {
        if($this->PhotoCheck) {
            $file = $this->PhotoCheck->download_file_url;
            if(!$file) return null;
            return $file;
        }
        return null;
    }
}
