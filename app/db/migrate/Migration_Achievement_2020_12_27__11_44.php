<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Achievement;

class Migration_Achievement_2020_12_27__11_44
{
    public string $model = 'Achievement';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Achievement::$table, 'number')) {
            $schema->alter('number', 'smallint', 3, true, null);
        }
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
