<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Item;

class Migration_Item_2020_12_17__19_06
{
    public string $model = 'Item';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Item::$table, 'upgrade_class')) {
            $schema->alter('upgrade_class', 'tinyint', 1, true, null);
        }
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
