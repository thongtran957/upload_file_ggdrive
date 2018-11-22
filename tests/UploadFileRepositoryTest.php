<?php

use App\Models\UploadFile;
use App\Repositories\UploadFileRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UploadFileRepositoryTest extends TestCase
{
    use MakeUploadFileTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var UploadFileRepository
     */
    protected $uploadFileRepo;

    public function setUp()
    {
        parent::setUp();
        $this->uploadFileRepo = App::make(UploadFileRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateUploadFile()
    {
        $uploadFile = $this->fakeUploadFileData();
        $createdUploadFile = $this->uploadFileRepo->create($uploadFile);
        $createdUploadFile = $createdUploadFile->toArray();
        $this->assertArrayHasKey('id', $createdUploadFile);
        $this->assertNotNull($createdUploadFile['id'], 'Created UploadFile must have id specified');
        $this->assertNotNull(UploadFile::find($createdUploadFile['id']), 'UploadFile with given id must be in DB');
        $this->assertModelData($uploadFile, $createdUploadFile);
    }

    /**
     * @test read
     */
    public function testReadUploadFile()
    {
        $uploadFile = $this->makeUploadFile();
        $dbUploadFile = $this->uploadFileRepo->find($uploadFile->id);
        $dbUploadFile = $dbUploadFile->toArray();
        $this->assertModelData($uploadFile->toArray(), $dbUploadFile);
    }

    /**
     * @test update
     */
    public function testUpdateUploadFile()
    {
        $uploadFile = $this->makeUploadFile();
        $fakeUploadFile = $this->fakeUploadFileData();
        $updatedUploadFile = $this->uploadFileRepo->update($fakeUploadFile, $uploadFile->id);
        $this->assertModelData($fakeUploadFile, $updatedUploadFile->toArray());
        $dbUploadFile = $this->uploadFileRepo->find($uploadFile->id);
        $this->assertModelData($fakeUploadFile, $dbUploadFile->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteUploadFile()
    {
        $uploadFile = $this->makeUploadFile();
        $resp = $this->uploadFileRepo->delete($uploadFile->id);
        $this->assertTrue($resp);
        $this->assertNull(UploadFile::find($uploadFile->id), 'UploadFile should not exist in DB');
    }
}
