<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    public function create(){
        $departments = DB::table('users_status');
        return response()->json([
            "departments" => $departments,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $department = Department::create($validatedData);
        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department
        ]);
    }

    public function edit($id){
        $department = Department::find($id);
        return response()->json([
            "department" => $department
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $department->update($validated);

        return response()->json(['message' => 'Product updated successfully']);
    }

    public function destroy($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $department->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
