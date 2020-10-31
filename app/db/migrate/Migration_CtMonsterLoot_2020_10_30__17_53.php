<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_CtMonsterLoot_2020_10_30__17_53
{
    public string $model = 'CtMonsterLoot';

    public function up(Schema $schema)
    {
        $schema->int('monster_id', 11)->index();
        $schema->int('item_id', 11)->index()->unique(['monster_id']);
        $schema->int('count', 11)->null();
        $schema->varchar('chance', 20);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
