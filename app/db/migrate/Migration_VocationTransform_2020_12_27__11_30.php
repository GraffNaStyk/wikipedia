<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\VocationTransform;

class Migration_VocationTransform_2020_12_27__11_30
{
    public string $model = 'VocationTransform';

    public function up(Schema $schema)
    {
        $schema->query('TRUNCATE TABLE '.VocationTransform::$table);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
