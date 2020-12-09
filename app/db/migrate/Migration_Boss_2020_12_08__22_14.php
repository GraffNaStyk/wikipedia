<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Boss_2020_12_08__22_14
{
    public string $model = 'Boss';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary();
        $schema->varchar('name', 80)->unique();
        $schema->varchar('place', 255);
        $schema->smallint('min_lvl', 4);
        $schema->smallint('max_lvl', 4);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
