<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UploadFileApiTest extends TestCase
{
    use MakeUploadFileTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateUploadFile()
    {
        $uploadFile = $this->fakeUploadFileData();
        $this->json('POST', '/api/v1/uploadFiles', $uploadFile);

        $this->assertApiResponse($uploadFile);
    }

    /**
     * @test
     */
    public function testReadUploadFile()
    {
        $uploadFile = $this->makeUploadFile();
        $this->json('GET', '/api/v1/uploadFiles/'.$uploadFile->id);

        $this->assertApiResponse($uploadFile->toArray());
    }

    /**
     * @test
     */
    public function testUpdateUploadFile()
    {
        $uploadFile = $this->makeUploadFile();
        $editedUploadFile = $this->fakeUploadFileData();

        $this->json('PUT', '/api/v1/uploadFiles/'.$uploadFile->id, $editedUploadFile);

        $this->assertApiResponse($editedUploadFile);
    }

    /**
     * @test
     */
    public function testDeleteUploadFile()
    {
        $uploadFile = $this->makeUploadFile();
        $this->json('DELETE', '/api/v1/uploadFiles/'.$uploadFile->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/uploadFiles/'.$uploadFile->id);

        $this->assertResponseStatus(404);
    }
}
