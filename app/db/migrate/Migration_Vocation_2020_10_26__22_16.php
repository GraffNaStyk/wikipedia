<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Vocation_2020_10_26__22_16
{
    public string $model = 'Vocation';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->varchar('name', 200)->unique();
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
