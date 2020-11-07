<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Image;

class Migration_Image_2020_11_07__11_42
{
    public string $model = 'Image';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Image::$table, 'ext')) {
            $schema->alter('ext', 'char', '5', false, 'jpg', 'after `hash`');
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
