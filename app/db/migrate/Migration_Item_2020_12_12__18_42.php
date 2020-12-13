<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Item;

class Migration_Item_2020_12_12__18_42
{
    public string $model = 'Item';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Item::$table, 'skill_sword')) {
            $schema->alter('skill_sword', 'smallint', 2, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'absorb_percent_magic')) {
            $schema->alter('absorb_percent_magic', 'smallint', 2, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'absorb_percent_psychical')) {
            $schema->alter('absorb_percent_psychical', 'smallint', 2, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'mana_leech_chance')) {
            $schema->alter('mana_leech_chance', 'smallint', 2, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'mana_leech_amount')) {
            $schema->alter('mana_leech_amount', 'smallint', 2, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'life_leech_chance')) {
            $schema->alter('life_leech_chance', 'smallint', 2, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'life_leech_amount')) {
            $schema->alter('life_leech_amount', 'smallint', 2, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'absorb_percent_all')) {
            $schema->alter('absorb_percent_all', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'critical_hit_chance')) {
            $schema->alter('critical_hit_chance', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'critical_hit_amount')) {
            $schema->alter('critical_hit_amount', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'magic_lvl_points')) {
            $schema->alter('magic_lvl_points', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'max_hit_points_percent')) {
            $schema->alter('max_hit_points_percent', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'max_mana_points_percent')) {
            $schema->alter('max_mana_points_percent', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'increase_healing_value')) {
            $schema->alter('increase_healing_value', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'increase_psychical_value')) {
            $schema->alter('increase_psychical_value', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'increase_psychical_percent')) {
            $schema->alter('increase_psychical_percent', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'magic_points_percent')) {
            $schema->alter('magic_points_percent', 'smallint', 2, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'health_gain')) {
            $schema->alter('health_gain', 'smallint', 4, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'mana_gain')) {
            $schema->alter('mana_gain', 'smallint', 4, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'health_ticks')) {
            $schema->alter('health_ticks', 'smallint', 4, true, 'null', 'after level');
        }
        
        if (! $schema->hasColumn(Item::$table, 'mana_ticks')) {
            $schema->alter('mana_ticks', 'smallint', 4, true, 'null', 'after level');
        }
    
        if ($schema->hasColumn(Item::$table, 'heal_percent')) {
            $schema->query('ALTER TABLE `items` CHANGE `heal_percent` `increase_healing_percent` INT(10) NULL DEFAULT NULL; ');
        }
        
        if ($schema->hasColumn(Item::$table, 'magic_hit_percent')) {
            $schema->query('ALTER TABLE `items` CHANGE `magic_hit_percent` `increase_magic_percent` INT(10) NULL DEFAULT NULL; ');
        }
        
        if ($schema->hasColumn(Item::$table, 'magic_hit_points')) {
            $schema->query('ALTER TABLE `items` CHANGE `magic_hit_points` `increase_magic_value` INT(10) NULL DEFAULT NULL; ');
        }
        
        if ($schema->hasColumn(Item::$table, 'max_heal')) {
            $schema->query('ALTER TABLE `items` CHANGE `max_heal` `max_hit_points` INT(10) NULL DEFAULT NULL; ');
        }
        
        if ($schema->hasColumn(Item::$table, 'max_ki')) {
            $schema->query('ALTER TABLE `items` CHANGE `max_ki` `max_mana_points` INT(10) NULL DEFAULT NULL; ');
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
