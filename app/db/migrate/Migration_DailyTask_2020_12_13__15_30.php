<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_DailyTask_2020_12_13__15_30
{
    public string $model = 'DailyTask';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary();
        $schema->varchar('monster', 50)->unique();
        $schema->smallint('from_lvl', 4);
        $schema->smallint('to_lvl', 4);
        $schema->int('money', 11);
        $schema->varchar('lvls', 5);
        $schema->tinyint('difficulty', 1);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
