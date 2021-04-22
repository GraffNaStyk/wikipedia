<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Quest_2020_11_30__22_04
{
    public string $model = 'Quest';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary();
        $schema->mediumInt('level', 5)->index();
        $schema->tinyint('status_points', 1);
        $schema->tinyint('snake_points', 1);
        $schema->tinyint('difficulty', 1);
        $schema->int('cid', )->unique();
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
