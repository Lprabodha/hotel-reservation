<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function users()
    {
        return view('admin.users.index');
    }

    public function userRoles()
    {
        return view('admin.users.roles.index');
    }

    public function deleteUser(Request $request)
    {
        User::find($request->id)->delete();

        return response()->json(['success' => 'User Delete successfully!']);
    }

    public function changeUserRole(Request $request)
    {
        $user = User::find($request->id);
        $role = Role::find($request->role_id);

        $user->roles()->detach();
        $role->users()->attach($user);

        return response()->json(['success' => 'User Role Change Successfully!']);
    }

    public function getUsers(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'role',
            4 => 'action',
        ];

        $totalData = User::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = User::offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = User::count();
        } else {
            $search = $request->input('search.value');
            $posts = User::where('name', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = User::where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%")
                ->count();
        }

        $data = [];

        if ($posts) {
            foreach ($posts as $r) {
                $nestedData['id'] = $r->id;
                $nestedData['name'] = $r->name;
                $nestedData['email'] = $r->email;
                $nestedData['role'] = '<span class="bg-'.$r->roles_color.'-focus text-'.$r->roles_color.'-main px-24 py-4 rounded-pill fw-medium">'.$r->roles[0]->name.'</span>';
                $nestedData['action'] = '<a class="btn btn-outline-primary-600 radius-8 px-20 py-11" data-data='.base64_encode($r).' data-bs-toggle="modal" data-bs-target="#changeRole"><i class="fas fa-edit"></i> Change Role</a>&nbsp;&nbsp;<a class="btn btn-outline-danger-600 radius-8 px-20 py-11"  onClick="deleteUser('.$r->id.')"> <i class="fas fa-trash"></i> Delete</a>';
                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        echo json_encode($json_data);
    }
}
