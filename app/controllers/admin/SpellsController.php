<?php

namespace App\Controllers\Admin;

use App\Facades\Http\Request;
use App\Model\Achievement;
use App\Model\Spell;

class SpellsController extends DashController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        return $this->render([
            'spells' => Spell::all()
        ]);
    }
    
    public function edit(int $id)
    {
        $desc = Spell::select(['description', 'image_id', 'type'])->where(['id', '=', $id])->findOrFail();
        $this->render(['id' => $id, 'description' => $desc['description']]);
    }
    
    public function update(Request $request)
    {
        if (! $this->validate($request->all(), [
            'id' => 'int|required',
            'description' => 'int|max:255|required',
            'image_id' => 'int',
            'type' => 'string|required'
        ])) {
            $this->sendError();
        }
    
        Spell::where(['id', '=', $request->get('id')])->update($request->all());
        $this->sendSuccess('Opis dodany poprawnie');
    }
}
