<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return Todo::all();
    }

    public function create(Request $request)
    {
        $todo = new Todo();
        $todo->content = $request->input('content');
        try {
            $todo->save();
        } catch (\Exception $e) {
            return ['success' => false];
        }

        return ['success' => true, 'todos' => Todo::all()];
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        $status = $todo->update(
            ['content' => $request->input('content')]
        );
        if ($status) {
            return ['success' => true, 'todos' => Todo::all()];
        } else {
            return ['success' => false];
        }
    }

    public function destroy($id)
    {
        Todo::destroy($id);

        return Todo::all();
    }
}
