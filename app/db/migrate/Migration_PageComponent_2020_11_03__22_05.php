<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\PageComponent;

class Migration_PageComponent_2020_11_03__22_05
{
    public string $model = 'PageComponent';

    public function up(Schema $schema)
    {
        if ( ! $schema->hasColumn(PageComponent::$table, 'rows')) {
            $schema->alter('rows', 'tinyint', '3', true, '1', 'after `is_active`');
        }
    
        if ( ! $schema->hasColumn(PageComponent::$table, 'cols')) {
            $schema->alter('cols', 'tinyint', '2', true, '1', 'after `is_active`');
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
    }
}
