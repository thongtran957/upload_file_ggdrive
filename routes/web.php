<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('put', function() {
    Storage::cloud()->put('hellosfr.txt', "Hello SFR's People");
    return 'File was saved to Google Drive';
});

Route::get('list', function() {
    $dir = '/';
    $recursive = false; // Có lấy file trong các thư mục con không?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));
    return $contents->where('type', '=', 'file');
});

Route::get('delete', function() {

    $filename = 'test.txt';
    $dir = '/';
    $recursive = false; 
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));
    $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); 
    Storage::cloud()->delete($file['path']);
    return 'File was deleted from Google Drive';
});



