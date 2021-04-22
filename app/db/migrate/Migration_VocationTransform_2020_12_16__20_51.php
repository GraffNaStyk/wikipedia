<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_VocationTransform_2020_12_16__20_51
{
    public string $model = 'VocationTransform';

    public function up(Schema $schema)
    {
        $schema->int('id')->primary();
        $schema->int('vocation_id')->index();
        $schema->int('transform_id')->index()->unique(['vocation_id']);
        $schema->varchar('melee_damage', 10);
        $schema->varchar('blast_damage', 10);
        $schema->varchar('ki_damage', 10);
        $schema->varchar('healing', 10);
        $schema->varchar('melee_absorb', 10);
        $schema->varchar('ki_absorb', 10);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
