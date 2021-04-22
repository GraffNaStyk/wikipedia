<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Page;

class Migration_Page_2020_11_30__22_06
{
    public string $model = 'Page';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Page::$table, 'parent_id')) {
            $schema->alter('parent_id', 'int', '11', true, null, 'after type');
            $schema->run();
        }
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
