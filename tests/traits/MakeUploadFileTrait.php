<?php

use Faker\Factory as Faker;
use App\Models\UploadFile;
use App\Repositories\UploadFileRepository;

trait MakeUploadFileTrait
{
    /**
     * Create fake instance of UploadFile and save it in database
     *
     * @param array $uploadFileFields
     * @return UploadFile
     */
    public function makeUploadFile($uploadFileFields = [])
    {
        /** @var UploadFileRepository $uploadFileRepo */
        $uploadFileRepo = App::make(UploadFileRepository::class);
        $theme = $this->fakeUploadFileData($uploadFileFields);
        return $uploadFileRepo->create($theme);
    }

    /**
     * Get fake instance of UploadFile
     *
     * @param array $uploadFileFields
     * @return UploadFile
     */
    public function fakeUploadFile($uploadFileFields = [])
    {
        return new UploadFile($this->fakeUploadFileData($uploadFileFields));
    }

    /**
     * Get fake data of UploadFile
     *
     * @param array $postFields
     * @return array
     */
    public function fakeUploadFileData($uploadFileFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'name_file' => $fake->text,
            'link_file' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $uploadFileFields);
    }
}
