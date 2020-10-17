<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Boots_2020_10_17__18_19
{
    public string $model = 'Boots';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->varchar('name', 50)->index()->unique();
        $schema->int('cid', 11);
        $schema->smallint('armor')->implicitly(0);
        $schema->text('description')->null();
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
