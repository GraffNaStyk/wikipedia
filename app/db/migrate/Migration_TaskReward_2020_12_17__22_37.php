<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_TaskReward_2020_12_17__22_37
{
    public string $model = 'TaskReward';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary();
        $schema->int('task_id')->index();
        $schema->tinyint('enable');
        $schema->int('values');
        $schema->varchar('type')->unique(['task_id']);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
