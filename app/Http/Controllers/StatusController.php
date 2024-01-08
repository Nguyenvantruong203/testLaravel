<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $status = Status::all();
        return response()->json($status);
    }

    public function create(){
        $departments = DB::table('departments');
        return response()->json([
            "departments" => $departments,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $department = Status::create($validatedData);
        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department
        ]);
    }

    public function edit($id){
        $department = Status::find($id);
        return response()->json([
            "department" => $department
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $department = Status::find($id);

        if (!$department) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $department->update($validated);

        return response()->json(['message' => 'Product updated successfully']);
    }

    public function destroy($id)
    {
        $department = Status::find($id);
        if (!$department) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $department->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
