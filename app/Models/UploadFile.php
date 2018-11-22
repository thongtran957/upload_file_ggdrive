<?php

namespace App\Models;

use Eloquent as Model;


/**
 * Class UploadFile
 * @package App\Models
 * @version November 22, 2018, 6:33 pm UTC
 *
 * @property string title
 * @property string name_file
 * @property string link_file
 */
class UploadFile extends Model
{

    public $table = 'upload_files';

    public $timestamps = false;
    
    public $fillable = [
        'title',
        'name_file',
        'link_file'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'name_file' => 'string',
        'link_file' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
