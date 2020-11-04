<?php

namespace App\Controllers\Admin;

use App\Facades\Http\Request;
use App\Helpers\Table;
use App\Model\PageComponent;

class TableComponentController extends DashController
{
    public function update(Request $request)
    {
        if (! $this->validate($request->all(), [
            'id' => 'required|int',
            'rows' => 'int|max:999',
            'cols' => 'int|max:99',
        ])) $this->sendError();
        
        $data = PageComponent::select(['data'])->where(['id', '=', $request->get('id')])->findOrFail();
        
        $request->set('data', json_encode(
            Table::prepareRowsAndCols(
                $request->get('rows'),
                $request->get('cols'),
                (array) json_decode($data['data'])
            )
        ));
    
        PageComponent::update($request->all());
    
        $this->sendSuccess('Zaktualizowano poprawnie');
    }
    
    public function edit(int $id)
    {
        if ($data = PageComponent::select(['cols', 'rows'])->where(['id', '=', $id])->findOrFail()) {
            return $this->render(['id' => $id, 'table' => $data]);
        }
    }
}
