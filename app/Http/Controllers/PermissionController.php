<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:permission_list|permission_create|permission_edit|permission_delete', ['only' => ['index','store']]);
        $this->middleware('permission:permission_create', ['only' => ['create','store']]);
        $this->middleware('permission:permission_edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC');
        if(request()->ajax()){
            return Datatables()->of($permissions)
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
        return view('backends.master.permission.index');
    }

    public function store(Request $request)
    {
        $permission_id = $request->permission_id;
        $permission = Permission::updateOrCreate(['id' => $permission_id],
                        [
                            'name' => $request->name,
                            'description' => $request->description,
                        ]);
        return response()->json($permission);
    }

    public function edit(Permission $permission)
    {
        $permission  = Permission::findOrFail($permission->id);
        return response()->json($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission  = Permission::findOrFail($permission->id);
        if ($permission->delete()) DB::table('role_has_permissions')->where('permission_id', $permission->id)->delete();
        return response()->json($permission);
    }
}
