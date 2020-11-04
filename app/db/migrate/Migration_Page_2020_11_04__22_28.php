<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Page;

class Migration_Page_2020_11_04__22_28
{
    public string $model = 'Page';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Page::$table, 'type')) {
            $schema->alter('type', 'varchar', '50', false, 'quest', 'after `is_active`');
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
