<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Saga_2020_12_03__22_26
{
    public string $model = 'Saga';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary()->unsigned();
        $schema->smallint('order', 3);
        $schema->varchar('name', 50)->unique();
        $schema->int('exp')->unsigned()->null();
        $schema->smallint('hp', 4)->unsigned()->null();
        $schema->int('ki', 4)->unsigned()->null();
        $schema->int('item')->unsigned()->null();
        $schema->smallint('count', 3)->null();
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
