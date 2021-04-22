<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Task_2020_12_17__22_36
{
    public string $model = 'Task';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary();
        $schema->varchar('monster')->unique();
        $schema->int('kills');
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
