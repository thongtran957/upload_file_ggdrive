<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUploadFileAPIRequest;
use App\Http\Requests\API\UpdateUploadFileAPIRequest;
use App\Models\UploadFile;
use App\Repositories\UploadFileRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class UploadFileController
 * @package App\Http\Controllers\API
 */

class UploadFileAPIController extends AppBaseController
{
    /** @var  UploadFileRepository */
    private $uploadFileRepository;

    public function __construct(UploadFileRepository $uploadFileRepo)
    {
        $this->uploadFileRepository = $uploadFileRepo;
    }

    /**
     * Display a listing of the UploadFile.
     * GET|HEAD /uploadFiles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->uploadFileRepository->pushCriteria(new RequestCriteria($request));
        $this->uploadFileRepository->pushCriteria(new LimitOffsetCriteria($request));
        $uploadFiles = $this->uploadFileRepository->all();

        return $this->sendResponse($uploadFiles->toArray(), 'Upload Files retrieved successfully');
    }

    /**
     * Store a newly created UploadFile in storage.
     * POST /uploadFiles
     *
     * @param CreateUploadFileAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUploadFileAPIRequest $request)
    {
        $input = $request->all();

        $uploadFiles = $this->uploadFileRepository->create($input);

        return $this->sendResponse($uploadFiles->toArray(), 'Upload File saved successfully');
    }

    /**
     * Display the specified UploadFile.
     * GET|HEAD /uploadFiles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UploadFile $uploadFile */
        $uploadFile = $this->uploadFileRepository->findWithoutFail($id);

        if (empty($uploadFile)) {
            return $this->sendError('Upload File not found');
        }

        return $this->sendResponse($uploadFile->toArray(), 'Upload File retrieved successfully');
    }

    /**
     * Update the specified UploadFile in storage.
     * PUT/PATCH /uploadFiles/{id}
     *
     * @param  int $id
     * @param UpdateUploadFileAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUploadFileAPIRequest $request)
    {
        $input = $request->all();

        /** @var UploadFile $uploadFile */
        $uploadFile = $this->uploadFileRepository->findWithoutFail($id);

        if (empty($uploadFile)) {
            return $this->sendError('Upload File not found');
        }

        $uploadFile = $this->uploadFileRepository->update($input, $id);

        return $this->sendResponse($uploadFile->toArray(), 'UploadFile updated successfully');
    }

    /**
     * Remove the specified UploadFile from storage.
     * DELETE /uploadFiles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UploadFile $uploadFile */
        $uploadFile = $this->uploadFileRepository->findWithoutFail($id);

        if (empty($uploadFile)) {
            return $this->sendError('Upload File not found');
        }

        $uploadFile->delete();

        return $this->sendResponse($id, 'Upload File deleted successfully');
    }

    public function add(Request $request){
        $input = $request->all();
        if($request->file_name != "undefined"){
            $file = $request->file_name;
         
            if(!empty($file)) {
                $name = $file->getClientOriginalName();
                $arrayName = explode('.', $name);
                $filename = $arrayName[0].'-'.time().'.'.$arrayName[1];
              
                $pathPublic = public_path().'/files/';
                if(\File::exists($pathPublic.$filename)){
                    unlink($pathPublic.$filename);
                }
                if(!\File::exists($pathPublic)) {
                    \File::makeDirectory($pathPublic, $mode = 0777, true, true);
                }
                $file->move($pathPublic, $filename);
                $fileData = \File::get($pathPublic.$filename);
                \Storage::cloud()->put($filename, $fileData);


                /**
                    TODO:
                    - lay ten luu vao database
                 */
                
               
                $dir = '/';
                $recursive = false; 
                $contents = collect(\Storage::cloud()->listContents($dir, $recursive));
                $link_file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->first(); 


                $link_file = 'https://drive.google.com/uc?id='.$link_file['path'];
                $name_file = $filename;

                /**
                    TODO:
                    - unlink anh trong public             
                 */
                
                unlink($pathPublic.$filename);

                $array = [
                    'title' => $input['title'],
                    'name_file' => $name_file,
                    'link_file' => $link_file,

                ];
                $result = UploadFile::create($array);


                return $this->sendResponse($result->toArray(), 'UploadFile saved successfully');
                
            }
        }

    }
}
