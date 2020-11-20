<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Npc_2020_11_17__22_23
{
    public string $model = 'Npc';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->index()->primary();
        $schema->varchar('name', 100)->unique()->index();
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
