<?php

namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Glover_2020_10_17__18_08
{
    public string $model = 'Glover';
    
    public function up(Schema $schema)
    {
        $schema->int('id', 11)->primary();
        $schema->varchar('name', 50)->index()->unique();
        $schema->int('cid', 11);
        $schema->smallint('defense', 3)->implicitly(0);
        $schema->smallint('attack', 3)->implicitly(0);
        $schema->text('description')->null();
        $schema->run();
    }
    
    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
