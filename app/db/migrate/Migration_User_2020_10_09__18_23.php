<?php

namespace App\Db\Migrate;

use App\Facades\Faker\Hash;
use App\Facades\Migrations\Schema;
use App\Model\User;

class Migration_User_2020_10_09__18_23
{
    public string $model = 'User';
    
    public function up(Schema $schema)
    {
        if ($schema->hasRecord('users', 'name', 'Graff') === false) {
            User::insert([
                'name' => 'Graff',
                'password' => Hash::crypt('mulias123'),
                'email' => 'kamil.lesniak94@gmail.com',
                'can_edit' => 1,
                'can_modify' => 1,
                'can_create_user' => 1
            ]);
            $schema->run();
        }
    }
    
    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
