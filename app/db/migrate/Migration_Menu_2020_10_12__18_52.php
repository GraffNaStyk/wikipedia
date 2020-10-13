<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Menu_2020_10_12__18_52
{
       public string $model = 'Menu';

       public function up(Schema $schema)
       {
           $schema->int('id', 11)->primary();
           $schema->varchar('name', 20)->index()->unique();
           $schema->varchar('icon_id', 200);
           $schema->int('parent_id', 11)->null()->foreign([
               'table' => 'menu',
               'field' => 'id',
               'onDelete' => 'cascade',
               'onUpdate' => 'cascade'
           ]);
           $schema->timestamp('created_at')->implicitly('CURRENT_TIMESTAMP');
           $schema->timestamp('updated_at')->onUpdate('CURRENT_TIMESTAMP')->null();
           $schema->run();
       }

       public function down(Schema $schema)
       {
           $schema->clear();
       }
}
