<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Spell_2020_10_26__22_11
{
    public string $model = 'Spell';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->varchar('name', 200)->unique();
        $schema->smallint('lvl', 4);
        $schema->smallint('train_points', 4)->implicitly(0);
        $schema->smallint('mana', 5)->implicitly(0);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
