<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:role_list|role_create|role_edit|role_delete', ['only' => ['index','store']]);
        $this->middleware('permission:role_create', ['only' => ['create','store']]);
        $this->middleware('permission:role_edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $role = auth()->user()->roles->pluck('name')[0];
        switch ($role) {
            case "Super Admin":
                $roles = Role::query();
                break;
            case "Admin":
                $roles = Role::whereNotIn('name', ['Super Admin'])->get();
                break;
        }

        if(request()->ajax()){
            return Datatables()->of($roles)
                ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-outline-warning btn-sm edit-post"><i class="far fa-edit"></i> Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</button>';
                    return $button;
                })
                ->addColumn('updated_at', function($data) {
                    return $data->updated_at->format('d-m-Y h:i:s A');
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backends.master.role.index');
    }

    public function store(Request $request)
    {
        $role_id = $request->role_id;
        $role = tap(Role::firstOrNew(['id' => $role_id]), function($newRole) use ($request) {
            $newRole->fill([ 'name' => $request->name ]);

            if ($newRole->save()) {
                $newRole->syncPermissions($request->permissions);
            }
        });
        return response()->json($role);
    }

    public function edit(Role $role)
    {
        $role  = Role::findOrFail($role->id);
        $rolePermissions = DB::table('role_has_permissions')
                                ->where('role_has_permissions.role_id', $role->id)
                                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                ->all();
        $data = [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ];
        return response()->json($data);
    }

    public function destroy(Role $role)
    {
        $role = Role::findOrFail($role->id);
        if ($role->delete()) DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
        return response()->json($role);
    }
}
