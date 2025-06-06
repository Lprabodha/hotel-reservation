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

    public function getUserProfile()
    {
        return view('admin.users.user-profile');
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
            3 => 'status',
            4 => 'action',
        ];

        $totalData = User::role('customer')->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = User::role('customer')
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = User::role('customer')->count();
        } else {
            $search = $request->input('search.value');
            $posts = User::role('customer')
                ->where('name', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = User::role('customer')
                ->where('name', 'like', "%{$search}%")
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
                $nestedData['status'] = $r->is_active ? '<span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium">Active</span>' : '<span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium">Inactive</span>';
                $nestedData['action'] = '<a class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"  onClick="deleteUser('.$r->id.')"> <iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a>';
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
