```php
use Illuminate\Support\Facades\App;
//example of pushing a image to s3 server named esgi-test-2
// to the key(folder) images
// the file test_couchdb
$s3 = App::make('aws')->createClient('s3'); $s3->putObject(array(
'Bucket' => 'esgi-test-2',
'Key' => 'images',
'SourceFile' => 'path to file/test_couchdb',
));
```
