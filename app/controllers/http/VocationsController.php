<?php

namespace App\Controllers\Http;

use App\Helpers\Storage;
use App\Model\Spell;
use App\Model\Vocation;
use App\Model\VocationTransform;

class VocationsController extends IndexController
{
    private array $transforms = [
        30,100,170,240,310,500,750
    ];
    
    private array $additionalSpell = [
        [
            'name' => 'Ki Blast',
            'lvl' => 1,
            'train_points' => 0,
            'mana' => 80
        ],
        [
            'name' => 'Bukujutsu',
            'lvl' => 15,
            'train_points' => 35,
            'mana' => 150
        ],
        [
            'name' => 'Gran Aura',
            'lvl' => 40,
            'train_points' => 70,
            'mana' => 200
        ],
        [
            'name' => 'Zanzoken',
            'lvl' => 50,
            'train_points' => 0,
            'mana' => 50
        ],
        [
            'name' => 'Instant transmission',
            'lvl' => 125,
            'train_points' => 125,
            'mana' => 5000
        ],
    ];
    
    public function __construct()
    {
        parent::__construct();
    }

    public function show(string $name)
    {
        $spells = Vocation::select(['s.*', 'vocations.id as voc_id'])
            ->join(['ct_vocations_spells as ct', 'vocations.id', '=', 'ct.vocation_id'])
            ->join(['spells as s', 's.id', '=', 'ct.spell_id'])
            ->where(['vocations.name', '=', $name])
            ->order(['s.lvl'], 'asc')
            ->get();
        
        if (empty($spells)) {
            $this->redirect('');
        }
        
        $vocId = $spells[0]['voc_id'];
        $spells = [...$spells, ...$this->additionalSpell];
    
        usort($spells, function ($a, $b) {
            return $a['lvl'] > $b['lvl'];
        });

        $vocation = Vocation::select('*')
            ->where(['id', '=', $vocId])
            ->findOrFail();

        $transforms = VocationTransform::select(['vocations_transforms.*', 'i.hash', 'i.path', 'i.ext'])
            ->leftJoin(['images as i', 'i.cid', '=' ,'vocations_transforms.outfit_id'])
            ->where(['vocations_transforms.vocation_id', '=', $vocId])
            ->order(['vocations_transforms.ki_damage'], 'asc')
            ->get();
        
        foreach ($transforms as $key => $transform) {
            $transforms[$key]['lvl'] = $this->transforms[$key];
        }

        $this->render([
            'spells' => $spells,
            'title' => $name,
            'transforms' => $transforms,
            'vocation' => $vocation
        ]);
    }
}
