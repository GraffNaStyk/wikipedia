<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_CtVocSpell_2020_10_26__22_17
{
    public string $model = 'CtVocSpell';

    public function up(Schema $schema)
    {
        $schema->int('vocation_id', 11)
            ->foreign([
                'table' => 'vocations',
                'field' => 'id',
                'onDelete' => 'cascade',
                'onUpdate' => 'cascade'
        ]);
        
        $schema->int('spell_id', 11)
            ->unique(['vocation_id'])
            ->foreign([
                'table' => 'spells',
                'field' => 'id',
                'onDelete' => 'cascade',
                'onUpdate' => 'cascade'
        ]);
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
