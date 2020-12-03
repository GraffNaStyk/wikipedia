<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Achievement_2020_12_02__22_17
{
    public string $model = 'Achievement';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary();
        $schema->varchar('name', 50)->unique();
        $schema->tinyint('status_points', 1);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
