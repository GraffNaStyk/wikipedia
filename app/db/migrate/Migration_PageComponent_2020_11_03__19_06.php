<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\PageComponent;

class Migration_PageComponent_2020_11_03__19_06
{
    public string $model = 'PageComponent';

    public function up(Schema $schema)
    {
        if ( ! $schema->hasColumn(PageComponent::$table, 'is_active')) {
            $schema->alter('is_active', 'tinyint', '1', false, '1', 'after `order`');
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
