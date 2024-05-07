<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:user_list|user_create|user_edit|user_delete', ['only' => ['index','store']]);
        $this->middleware('permission:user_create', ['only' => ['create','store']]);
        $this->middleware('permission:user_edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = auth()->user()->roles->pluck('name')[0];
        switch ($role) {
            case "Super Admin":
                $users = User::with('roles');
                break;
            case "Admin":
                $users = User::with('roles')->whereHas("roles", function($query) { $query->whereNotIn("name", ["Super Admin"]); });
                break;
        }
        // $users = User::all();
        if( request()->ajax() ){
            return Datatables()->of($users)
                ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-outline-warning btn-sm edit-post"><i class="far fa-edit"></i> Edit</a>';
                     $button .= '&nbsp;&nbsp;';
                     $button .='<input data-id="'.$data->id.'" class="toggle-class" type="checkbox" data-toggle="toggle" data-on="Active" data-off="Unactive" data-onstyle="success" data-offstyle="danger">';
//                     $button .= '<button type="button" name="delete" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</button>';
                    return $button;
                })
                ->addColumn('role', function($data) {
                    return ucwords($data->roles->pluck('name')[0]);
                })
                ->editColumn('updated_by', function($data) {
                    return ucwords(User::findOrFail($data->updated_by)->name);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('backends.master.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $user = tap(User::firstOrNew(['id' => $user_id]), function($newUser) use ($request) {
            $newUser->fill([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            if (!empty($request->password)) $newUser->password = Hash::make($request->password);
            if ($newUser->save()) $newUser->syncRoles($request->role_id);
        });
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = User::with('roles')->findOrFail($user->id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function getChangeStatus(Request $request)
    {
        $user  = User::findOrFail($request->user_id);
        if ($user) {
            $user->is_active = $request->is_active;
            $user->save();
            return response()->json($user);
        }
    }
}
