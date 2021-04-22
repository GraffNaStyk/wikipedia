<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_ExtremeTask_2020_12_14__18_54
{
    public string $model = 'ExtremeTask';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary();
        $schema->varchar('monster', 50)->unique();
        $schema->int('normal_exp', 11);
        $schema->int('special_exp', 11);
        $schema->smallint('kills', 4);
        $schema->tinyint('difficulty', 1);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
