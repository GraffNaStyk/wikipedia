<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Vocation;

class Migration_Vocation_2020_12_16__20_36
{
    public string $model = 'Vocation';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Vocation::$table, 'hp')) {
            $schema->alter('hp', 'smallint', 4, true, 'null', 'after name');
        }
    
        if (! $schema->hasColumn(Vocation::$table, 'ki')) {
            $schema->alter('ki', 'smallint', 4, true, 'null', 'after name');
        }
    
        if (! $schema->hasColumn(Vocation::$table, 'cap')) {
            $schema->alter('cap', 'smallint', 4, true, 'null', 'after name');
        }
    
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
