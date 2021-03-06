<?php
namespace App\Facades\Migrations;

use App\Helpers\Storage;

class Migration
{
    private array $args = [];
    
    public function __construct($args)
    {
        $this->args = $args;
    }

    public function make()
    {
        $migration = file_get_contents(app_path('app/facades/migrations/migration'));
        $migration = str_replace('CLASSNAME', 'Migration_'.$this->args[2].'_'.date('Y_m_d__H_i'), $migration);
        $migration = str_replace('MODEL', $this->args[2], $migration);

        if (is_dir(app_path('app/db/migrate/')) === false) {
            mkdir(app_path('app/db/migrate/'), 0775, true);
        }

        file_put_contents(app_path('app/db/migrate/Migration_'.$this->args[2].'_'.date('Y_m_d__H_i').'.php'), "<?php ".$migration);

        if(file_exists(app_path('app/model/'.ucfirst($this->args[2]).'.php')) === false) {
            $model = file_get_contents(app_path('app/facades/migrations/model'));
            $model = str_replace('CLASSNAME', ucfirst($this->args[2]), $model);
            $model = str_replace('TABLE', $this->args[3], $model);
            file_put_contents(app_path('app/model/'.ucfirst($this->args[2]).'.php'), "<?php ".$model);
        }
    }

    public function up(bool $isDump = false)
    {
        $this->makeJsonFile();
        $migrationContent = (array) json_decode(
            Storage::disk('private')->getContent('db/migrations.json')
            , true
        );

        foreach ($this->sortByDate(glob(app_path('app/db/migrate/Migration_*.php'))) as $migration) {
            $migration = 'App\\Db\\Migrate\\'.basename(str_replace('.php','', $migration));

            if (!isset($migrationContent[$migration]) || $isDump) {
                $migrationContent[$migration] = ['date' => date('Y-m-d H:i:s')];
                $migration = new $migration();
                $migration->up(new Schema(app['model-provider'].$migration->model, $isDump));
            }
        }
        
        Storage::disk('private')->put('db/migrations.json', json_encode($migrationContent, JSON_PRETTY_PRINT), true);
    }

    public function down()
    {
        $this->makeJsonFile(true);
        
        foreach (glob(app_path('app/db/migrate/Migration_*.php')) as $migration) {
            $migration = 'App\\Db\\Migrate\\'.basename(str_replace('.php','', $migration));
            $migration = new $migration();
            $migration->down(new Schema(app['model-provider'].$migration->model));
        }
        
        Storage::disk('private')->remove('db/migrations.json');
    }

    public function dump()
    {
        $this->up(true);
    }

    private function makeJsonFile($replace = false)
    {
        Storage::disk('private')->make('db');
        Storage::disk('private')->put('db/migrations.json', '{}', $replace);
    }
    
    private function sortByDate(array $files): array
    {
        $migrations = [];
        foreach ($files as $key => $file) {
            $tmp = str_replace(app_path('app/db/migrate/Migration_'), '', $file);
            $tmp = preg_replace('/[a-zA-Z__.]/', '', $tmp);
            $migrations[$tmp] = $file;
        }
        
        ksort($migrations);
        return $migrations;
    }
}
