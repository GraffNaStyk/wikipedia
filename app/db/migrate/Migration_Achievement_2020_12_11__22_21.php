<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Achievement;

class Migration_Achievement_2020_12_11__22_21
{
    public string $model = 'Achievement';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Achievement::$table, 'description')) {
            $schema->alter('description', 'varchar', 255, true, 'NULL');
            $schema->run();
        }
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
