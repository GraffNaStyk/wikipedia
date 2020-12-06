<?php

namespace App\Facades\Parser;

use App\Model\CtVocSpell;
use App\Model\Spell;
use App\Model\Vocation;

class Spells
{
    protected static array $vocations;
    protected static array $spells;
    protected static int $iterator = 0;
    
    public static function parse()
    {
        if (is_readable(app('spells_path'))) {
            foreach (simplexml_load_file(app('spells_path')) as $key => $item) {
                $item = get_object_vars($item);

                if (substr($item['@attributes']['name'], 0, 3) === 'mon') {
                    continue;
                }
                
                self::spellFactory($item);
               
            }
        } else {
            exit('file not exist');
        }
   
        self::$vocations = array_values(array_unique(array_filter(self::$vocations)));

        foreach (self::$vocations as $vocation) {
            Vocation::insert(['name' => $vocation]);
        }
        
        foreach (self::$spells as $spell) {
            $tmpVoc = $spell['vocations'];
            unset($spell['vocations']);
            if ((bool) $spell['mana']) {
                Spell::insert($spell);
                $id = Spell::lastId();
    
                if (!empty($tmpVoc) && (int) $id !== 0) {
                    foreach ($tmpVoc as $vocation) {
                        if ($vocId = Vocation::select(['id'])->where(['name', '=', $vocation])->findOrFail()) {
                            CtVocSpell::insert(['vocation_id' => $vocId['id'], 'spell_id' => $id]);
                        }
                    }
                }
            }
        }
    }
    
    private static function spellFactory(array $spell)
    {
        self::$spells[self::$iterator]['name'] = $spell['@attributes']['name'];
        self::$spells[self::$iterator]['lvl'] = $spell['@attributes']['lvl'];
        self::$spells[self::$iterator]['mana'] = $spell['@attributes']['mana'];
        self::$spells[self::$iterator]['train_points'] = $spell['@attributes']['trainpoints'] ?? 0;
    
        if (isset($spell['vocation'])) {
            $vocations = self::vocationsFactory((array) $spell['vocation']);
            self::$spells[self::$iterator]['vocations'] = $vocations;
        }
        
        self::$iterator++;
    }
    
    private static function vocationsFactory(array $vocations): array
    {
        $tmp = [];
        
        if (isset($vocations['@attributes'])) {
            self::$vocations[] = $vocations['@attributes']['name'];
            $tmp[] = $vocations['@attributes']['name'];
        } else {
            foreach ($vocations as $vocation) {
                $vocation = get_object_vars($vocation);
                self::$vocations[] = $vocation['@attributes']['name'];
                $tmp[] = $vocation['@attributes']['name'];
            }
        }
        
        return $tmp;
    }
}
