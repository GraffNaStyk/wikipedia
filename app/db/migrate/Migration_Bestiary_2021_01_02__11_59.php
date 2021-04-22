<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Bestiary_2021_01_02__11_59
{
    public string $model = 'Bestiary';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->int('monster_cid', 11);
        $schema->tinyint('stage', 1)->unique(['monster_cid']);
        $schema->int('kills', 11);
        $schema->varchar('reward_type', 50);
        $schema->int('reward_value', 11);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
