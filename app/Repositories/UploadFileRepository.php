<?php

namespace App\Repositories;

use App\Models\UploadFile;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UploadFileRepository
 * @package App\Repositories
 * @version November 22, 2018, 6:33 pm UTC
 *
 * @method UploadFile findWithoutFail($id, $columns = ['*'])
 * @method UploadFile find($id, $columns = ['*'])
 * @method UploadFile first($columns = ['*'])
*/
class UploadFileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'name_file',
        'link_file'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UploadFile::class;
    }
}
