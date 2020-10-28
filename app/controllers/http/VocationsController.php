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
        $spells = Vocation::select(['s.*'])
            ->join(['ct_vocations_spells as ct', 'vocations.id', '=', 'ct.vocation_id'])
            ->join(['spells as s', 's.id', '=', 'ct.spell_id'])
            ->where(['vocations.name', '=', $name])
            ->order('s.lvl', 'asc')
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
