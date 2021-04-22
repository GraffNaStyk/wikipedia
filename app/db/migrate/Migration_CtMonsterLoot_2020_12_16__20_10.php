<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\CtMonsterLoot;

class Migration_CtMonsterLoot_2020_12_16__20_10
{
    public string $model = 'CtMonsterLoot';

    public function up(Schema $schema)
    {
        $schema->query('truncate table '.CtMonsterLoot::$table);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
