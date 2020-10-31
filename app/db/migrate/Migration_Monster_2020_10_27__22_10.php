<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Monster_2020_10_27__22_10
{
    public string $model = 'Monster';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->varchar('name', 100)->index()->unique();
        $schema->varchar('race', 50)->index();
        $schema->int('health', 11);
        $schema->int('experience', 11);
        $schema->smallint('speed', 5);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
