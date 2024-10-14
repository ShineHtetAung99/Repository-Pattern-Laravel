<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'photo'
    ];
    
    protected $with = ['photos'];

    protected $hidden = ['PhotoCheck','created_at','updated_at'];

    protected $appends = ['profile_url','download_profile_url'];

    public function photos()
    {
        return $this->hasMany(CustomerUpload::class,'customer_id','id');
    }


    public function PhotoCheck()
    {
        return $this->hasOne(File::class,'id','photo');
    }

    public function getProfileUrlAttribute()
    {
        if($this->PhotoCheck) {
            $fielUrl = $this->PhotoCheck->file_url;
            if(!$fielUrl) return null;
            return $fielUrl;
        }
        return null;
    }
    public function getDownloadProfileUrlAttribute()
    {
        if($this->PhotoCheck) {
            $file = $this->PhotoCheck->download_file_url;
            if(!$file) return null;
            return $file;
        }
        return null;
    }

}
