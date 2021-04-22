<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_PageComponent_2020_11_02__22_08
{
    public string $model = 'PageComponent';

    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->int('page_id', 11)->foreign([
            'table' => 'pages',
            'field' => 'id',
            'onDelete' => 'cascade',
            'onUpdate' => 'cascade'
        ]);
        $schema->varchar('type', 50);
        $schema->tinyint('order', 2)->implicitly(0);
        $schema->longText('data')->null();
        $schema->run();
    }

    public function down(Schema $schema)
    {
    }
}
