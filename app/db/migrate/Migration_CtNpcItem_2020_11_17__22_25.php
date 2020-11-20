<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_CtNpcItem_2020_11_17__22_25
{
    public string $model = 'CtNpcItem';

    public function up(Schema $schema)
    {
        $schema->int('npc_id', 11)->index();
        $schema->int('item_cid', 11)->index()->unique(['npc_id']);
        $schema->int('price', 11);
        $schema->varchar('type', 20);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
