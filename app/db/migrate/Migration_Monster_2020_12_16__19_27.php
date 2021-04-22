<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Monster;

class Migration_Monster_2020_12_16__19_27
{
    public string $model = 'Monster';

    public function up(Schema $schema)
    {
        Monster::where(['name', '=', 'Death Machine'])->update(['experience' => 2750]);
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
