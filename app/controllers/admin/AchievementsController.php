<?php

namespace App\Controllers\Admin;

use App\Facades\Http\Request;
use App\Model\Achievement;

class AchievementsController extends DashController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        return $this->render([
            'achievements' => Achievement::all()
        ]);
    }
    
    public function edit(int $id)
    {
        $desc = Achievement::select(['description'])->where(['id', '=', $id])->findOrFail();
        $this->render(['id' => $id, 'description' => $desc['description']]);
    }
    
    public function update(Request $request)
    {
        if (! $this->validate($request->all(), [
            'id' => 'int|required',
            'description' => 'string|max:255'
        ])) {
            $this->sendError();
        }
        
        Achievement::where(['id', '=', $request->get('id')])->update($request->all());
        $this->sendSuccess('Opis dodany poprawnie');
    }
}
