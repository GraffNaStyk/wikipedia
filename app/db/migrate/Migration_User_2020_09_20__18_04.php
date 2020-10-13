<?php

namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_User_2020_09_20__18_04
{
    public string $model = 'User';
    
    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->varchar('name', 50)->unique()->index();
        $schema->varchar('password', 100);
        $schema->varchar('email', 50);
        $schema->tinyint('can_edit', 1)->implicitly(0);
        $schema->tinyint('can_modify', 1)->implicitly(0);
        $schema->tinyint('can_create_user', 1)->implicitly(0);
        $schema->timestamp('created_at')->implicitly('CURRENT_TIMESTAMP');
        $schema->timestamp('updated_at')->onUpdate('CURRENT_TIMESTAMP')->null();
        $schema->run();
    }
    
    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
