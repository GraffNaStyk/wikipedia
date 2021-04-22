<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Item;

class Migration_Item_2020_12_12__22_39
{
    public string $model = 'Item';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Item::$table, 'skill_shield')) {
            $schema->alter('skill_shield', 'smallint', 4, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'skill_fist')) {
            $schema->alter('skill_fist', 'smallint', 4, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'skill_dist')) {
            $schema->alter('skill_dist', 'smallint', 4, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'skill_club')) {
            $schema->alter('skill_club', 'smallint', 4, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'skill_axe')) {
            $schema->alter('skill_axe', 'smallint', 4, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'skill_sword')) {
            $schema->alter('skill_sword', 'smallint', 4, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'skill_fish')) {
            $schema->alter('skill_fish', 'smallint', 4, true, 'null', 'after level');
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
