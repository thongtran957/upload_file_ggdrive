<template>
	<div>
		<div class="display-1">
			Lưu trữ file với Google Drive trong Laravel
		</div>

		<v-container>
			<div class="heading" style="font-size:22px">
				<p>1.Cài đặt Package</p>
				<div style="font-size:18px; margin-left: 25px">
					<p>Package Sử dụng: <a href="https://github.com/nao-pon/flysystem-google-drive">flysystem-google-drive </a></p>
					<ul>
						<li>
							<p>Cài đặt package cho Google Drive API V3</p>
						  	<v-card-text class="pink lighten-2">
				          	composer require nao-pon/flysystem-google-drive:~1.1
					        </v-card-text>
						</li>
						<li>
							<p>Sau khi cài đặt package xong, chúng ta cần thêm <i>GoogleDriveServiceProvider::class</i>, vào providers trong file <i>config/app.php</i></p>
						  	<v-card-text class="pink lighten-2">
						  		<pre>
'providers' => [
    // ...
    App\Providers\GoogleDriveServiceProvider::class,
    // ...
],
								</pre>
					        </v-card-text>
						</li>
						<li>
							<p>Thêm <i>google</i> disk vào <i>config/filesystems.php</i></p>
						  	<v-card-text class="pink lighten-2">
						  		<pre>
'disks' => [
    // ...
    'google' => [
        'driver' => 'google',
        'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
        'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
        'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
        'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
    ],
    // ...
],
								</pre>
					        </v-card-text>
						</li>
					</ul>
					
				</div>
			</div>
			
			<div class="heading" style="font-size:22px">
				<p>2.Sử dụng</p>
				<div style="font-size:18px; margin-left: 25px">
					<p>2.1.Tạo Google Drive API keys</p>
					<div class="sub">
						<p>Để lưu trữ file trên Google Drive, bạn cần lấy đủ 4 thông tin bên trên. Để có thông tin chi tiết về cách lấy API ID, secret và refresh token, bạn tham khảo hướng dẫn sau:</p>
						<ul>
							<li>
								<a href="https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/1-getting-your-dlient-id-and-secret.md" target="_blank">Lấy Client ID and Secret</a>
							</li>
							<li>
								<a href="https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/2-getting-your-refresh-token.md" target="_blank">Lấy Refresh Token</a>
							</li>
							<li>
								<a href="https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/3-getting-your-root-folder-id.md" target="_blank">Lấy ID thư mục lưu trữ</a>
							</li>
						</ul>
						<p>Lưu ý: khi tại Authorized redirect URIs ta có thể thêm nhu sau :</p>
						<v-card-text class="pink lighten-2">
			          		https://developers.google.com/oauthplayground
				        </v-card-text>
			    	</div>
			        <p>2.2.Cập nhật file .env và test</p>
			        <div class="sub">
			        	<ul>
			        		<li>
			        			<p>Để lưu trữ file trên Google Drive, bạn cần lấy đủ 4 thông tin bên trên. Để có thông tin chi tiết về cách lấy API ID, secret và refresh token, bạn tham khảo hướng dẫn sau:</p>
			        			<v-card-text class="pink lighten-2">
						  		<pre>
FILESYSTEM_CLOUD=google
GOOGLE_DRIVE_CLIENT_ID=xxx.apps.googleusercontent.com
GOOGLE_DRIVE_CLIENT_SECRET=xxx
GOOGLE_DRIVE_REFRESH_TOKEN=xxx
GOOGLE_DRIVE_FOLDER_ID=null
								</pre>
					        </v-card-text>
			        		</li>
			        		<li>
			        			<p>Tạo file <i>app/Providers/GoogleDriveServiceProvider.php</i></p>
			        			<v-card-text class="pink lighten-2">
						  		<pre>
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Storage::extend('google', function($app, $config) {
            $client = new \Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);
            $service = new \Google_Service_Drive($client);
            $options = [];
            if(isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }
            $adapter = new GoogleDriveAdapter($service, $config['folderId'], $options);
            return new \League\Flysystem\Filesystem($adapter);
        });
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
								</pre>
					        </v-card-text>
			        		</li>
			        		<li>
			        			<p>Ta có thể test như sau </p>
			        			<v-card-text class="pink lighten-2">
						  		<pre>
Route::get('test', function() {
   $test=Storage::cloud();
	dd($test);
});
								</pre>
					        </v-card-text>
			        		</li>
			        	</ul>
			        </div>
			        <p>2.3.Code</p>
			        <div class="sub">
			        	<ul>
			        		<li>
			        			<p>Tạo file mới</p>
			        			<v-card-text class="pink lighten-2">
						  		<pre>
Route::get('put', function() {
    Storage::cloud()->put('hellosfr.txt', 'Hello SFR's People);
    return 'File was saved to Google Drive';
});
								</pre>
					        </v-card-text>
					        <p>Kết quả:</p>
					        <p>
					        <img src="https://drive.google.com/uc?id=14y6TpYfaCitDLV7ZFNMXnXqfZhip0lbt" class="fix-img">
					    	</p>
					    	<p>
					         <img src="https://drive.google.com/uc?id=1CMwh-yUrYDGkZ2k_esFQIDVXtOfcMzU9" class="fix-img">
					    	 </p>
			        		</li>
			        	</ul>
			        </div>
				</div>
			</div>	

			<div class="heading" style="font-size:22px">
				<p>3.Tham khảo</p>
				<div style="font-size:18px; margin-left: 25px">
					<ul>
						<li>
							<p>Bảng định tuyến có sẵn :<a href="https://github.com/ivanvermeyen/laravel-google-drive-demo">Available routes</a></p>
						</li>
						<li>
							<p>Link demo :<a href="http://uploadfiletoggdrive.herokuapp.com">demo.com</a></p>
						</li>
						<li>
							<p>Link github soure :<a href="https://github.com/thongtran957/upload_file_ggdrive/tree/upload_file">github.com</a></p>
		
						</li>
					</ul>
					
				</div>
				
			</div>
		</v-container>

	</div>
</template>

<script>
export default {

  name: 'Tutorial',

  data () {
    return {

    }
  }
}
</script>

<style lang="css" scoped>
</style>