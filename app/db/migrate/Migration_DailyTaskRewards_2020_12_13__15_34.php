<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_DailyTaskRewards_2020_12_13__15_34
{
    public string $model = 'DailyTaskReward';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->int('task_id', 11);
        $schema->int('item_max_count', 11);
        $schema->int('item_id', 11)->unique(['task_id']);
        $schema->int('item_chance', 11);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
