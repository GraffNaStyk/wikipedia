<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Article_2020_10_12__20_00
{
       public string $model = 'Article';

       public function up(Schema $schema)
       {
           $schema->int('id', 11)->primary();
           $schema->varchar('title', 50)->index();
           $schema->text('content')->null();
           $schema->text('config')->null();
           $schema->varchar('type', 15);
           $schema->int('created_by', 11);
           $schema->int('updated_by', 11)->null();
           $schema->timestamp('created_at')->implicitly('CURRENT_TIMESTAMP');
           $schema->timestamp('updated_at')->onUpdate('CURRENT_TIMESTAMP')->null();
           $schema->run();
       }

       public function down(Schema $schema)
       {
           $schema->clear();
       }
}
