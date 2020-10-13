<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Image_2020_10_12__19_59
{
       public string $model = 'Image';

       public function up(Schema $schema)
       {
           $schema->int('id', 11)->primary();
           $schema->varchar('name', 200);
           $schema->varchar('path', 200);
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
