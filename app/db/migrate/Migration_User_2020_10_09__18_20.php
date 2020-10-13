<?php

namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_User_2020_10_09__18_20
{
    public string $model = 'User';
    
    public function up(Schema $schema)
    {
        $schema->trigger(
            'on_create_user',
            'after',
            'insert',
            'insert into rights (user_id) values (NEW.id)'
        );
        $schema->run();
    }
    
    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
