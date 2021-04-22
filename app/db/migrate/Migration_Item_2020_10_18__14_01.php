<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Item_2020_10_18__14_01
{
    public string $model = 'Item';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->varchar('name', 50)->index()->unique();
        $schema->int('cid', 11);
        $schema->smallint('defense', 3)->implicitly(0);
        $schema->smallint('armor', 3)->implicitly(0);
        $schema->smallint('attack', 3)->implicitly(0);
        $schema->smallint('range', 3)->implicitly(0);
        $schema->smallint('level', 3)->implicitly(0);
        $schema->varchar('type', 50);
        $schema->int('weight', 10)->implicitly(0);
        $schema->text('description')->null();
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
