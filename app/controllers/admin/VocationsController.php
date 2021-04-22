<?php

namespace App\Controllers\Admin;

use App\Facades\Http\Request;
use App\Model\Achievement;
use App\Model\Vocation;

class VocationsController extends DashController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        return $this->render([
            'vocations' => Vocation::all()
        ]);
    }
    
    public function edit(int $id)
    {
        $desc = Vocation::select(['description'])->where(['id', '=', $id])->findOrFail();
        $this->render(['id' => $id, 'description' => $desc['description']]);
    }
    
    public function update(Request $request)
    {
        if (! $this->validate($request->all(), [
            'id' => 'int|required',
            'description' => 'string|required'
        ])) {
            $this->sendError();
        }
    
        Vocation::where(['id', '=', $request->get('id')])->update($request->all());
        $this->sendSuccess('Opis dodany poprawnie');
    }
}
