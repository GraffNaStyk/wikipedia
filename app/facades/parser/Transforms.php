<?php

namespace App\Facades\Parser;

use App\Model\Vocation;
use App\Model\VocationTransform;

class Transforms
{
    private static array $coContinue = [
        1,7,13,19,24,29,35,41,47,53,59,64,71,77,84,89,170
    ];
    
    public static function parse()
    {
        if (is_readable(app('vocations_path'))) {
            $transforms = simplexml_load_file(app('vocations_path'));

            foreach ($transforms as $transform) {
                $transform = get_object_vars($transform);
                $prof = $transform['@attributes'];
                
                if ($id = Vocation::where(['name', '=', $prof['name']])->select(['id'])->findOrFail()) {
                    
                    $attr = get_object_vars($transform['formula'])['@attributes'];
                    Vocation::where(['id', '=', $id['id']])->update([
                        'hp' => (int) $prof['gainhp'],
                        'ki' => (int) $prof['gainmana'],
                        'cap' => (int) $prof['gaincap'],
                    ]);
                    
                    if (! in_array($prof['id'], self::$coContinue)) {
                        VocationTransform::insert([
                            'vocation_id' => $id['id'],
                            'transform_id' => $prof['id'],
                            'melee_damage' => $attr['meleeDamage']*100,
                            'blast_damage' => $attr['distDamage']*100,
                            'ki_damage' => $attr['magDamage'],
                            'healing' => $attr['magHealingDamage']*100,
                            'melee_absorb' => $attr['meeleAbsorb'],
                            'ki_absorb' => $attr['magAbsorb'],
                        ]);
                    }
                }
            }
        }
        
        if (is_readable(app('transform_path'))) {
            $transforms = json_decode(file_get_contents(app('transform_path')));

            foreach ($transforms as $transform) {
                VocationTransform::where(['transform_id', '=', $transform->vAfter])->update([
                    'ki' => (int) $transform->ki,
                    'hp' => (int) $transform->hp,
                    'outfit_id' => (int) $transform->lookAfter,
                    'is_constant' => (int) $transform->const,
                ]);
            }
        }
    }
}
