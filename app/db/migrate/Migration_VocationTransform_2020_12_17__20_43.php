<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\VocationTransform;

class Migration_VocationTransform_2020_12_17__20_43
{
    public string $model = 'VocationTransform';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(VocationTransform::$table, 'hp')) {
            $schema->alter('hp', 'smallint', 4, true, null);
        }
    
        if (! $schema->hasColumn(VocationTransform::$table, 'ki')) {
            $schema->alter('ki', 'smallint', 4, true, null);
        }
    
        if (! $schema->hasColumn(VocationTransform::$table, 'is_constant')) {
            $schema->alter('is_constant', 'tinyint', 1, false, 0);
        }
    
        if (! $schema->hasColumn(VocationTransform::$table, 'outfit_id')) {
            $schema->alter('outfit_id', 'mediumint', 5, false, 1);
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
