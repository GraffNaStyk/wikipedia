<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Menu;

class Migration_Menu_2020_10_14__19_58
{
       public string $model = 'Menu';
       
       protected array $menuItems = [
           'Dashboard', 'Proffessions', 'Missions',
           'Items', 'Systems', 'Monsters', 'Maps', 'Events'
       ];
       
       public function up(Schema $schema)
       {
           if ($schema->hasTable('menu')) {
                if (Menu::where()) {
                    
                }
           }
           
           $schema->run();
       }

       public function down(Schema $schema)
       {
           $schema->clear();
       }
}
