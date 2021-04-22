<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Spell;

class Migration_Spell_2020_12_19__10_37
{
    public string $model = 'Spell';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Spell::$table, 'description')) {
            $schema->alter('description', 'text', '', true, null);
        }
    
        if (! $schema->hasColumn(Spell::$table, 'type')) {
            $schema->alter('type', 'varchar', '30', true, null);
        }
    
        if (! $schema->hasColumn(Spell::$table, 'image_id')) {
            $schema->alter('image_id', 'int', '11', true, null);
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
