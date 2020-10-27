<?php

namespace App\Controllers\Http;

use App\Model\Spell;
use App\Model\Vocation;

class VocationsController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show(string $name)
    {
        $spells = Vocation::select(['spells.*'])
            ->join(['ct_vocations_spells', 'vocations.id', '=', 'ct_vocations_spells.vocation_id'])
            ->join(['spells', 'spells.id', '=', 'ct_vocations_spells.spell_id'])
            ->where(['vocations.name', '=', $name])
            ->order('spells.lvl', 'asc')
            ->get();
        
        if (empty($spells)) {
            $this->redirect('');
        }
        
        $this->render([
            'spells' => $spells,
            'title' => $name
        ]);
    }
}
