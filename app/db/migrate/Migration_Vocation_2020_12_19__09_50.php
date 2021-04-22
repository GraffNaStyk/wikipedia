<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Vocation;

class Migration_Vocation_2020_12_19__09_50
{
    public string $model = 'Vocation';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Vocation::$table, 'description')) {
            $schema->alter('description', 'text', '', true, null);
        }
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
