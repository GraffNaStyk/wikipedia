<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;

class Migration_Monster_2020_12_16__19_19
{
    public string $model = 'Monster';

    public function up(Schema $schema)
    {
        $schema->query('ALTER TABLE `monsters` ADD UNIQUE `unique_index`(`name`, `cid`);');
        $schema->query('ALTER TABLE `monsters` DROP INDEX `name_2`;');
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
