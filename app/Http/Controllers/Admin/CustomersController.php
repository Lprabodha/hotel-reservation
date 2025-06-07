<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {
        return view('admin.customers.index');
    }

    public function show(Request $request)
    {

        $columns = [
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'status',
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
