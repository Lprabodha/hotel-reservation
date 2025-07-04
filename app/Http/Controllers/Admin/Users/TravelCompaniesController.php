<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelCompanyRequest;
use App\Mail\SendMail;
use App\Models\TravelCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TravelCompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-travel-companies', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-travel-companies', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-travel-companies', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-travel-companies', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.travel-companies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.travel-companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TravelCompanyRequest $request)
    {

        DB::transaction(function () use ($request) {
            $password = random_int(10000000, 99999999);
            $hashedPassword = Hash::make($password);

            $email = $request->email;
            $companyName = $request->company_name;

            $user = User::create([
                'name' => $companyName,
                'email' => $email,
                'password' => $hashedPassword,
            ]);

            $user->assignRole('travel-company');

            TravelCompany::create([
                'user_id' => $user['id'],
                'company_name' => $companyName,
                'email' => $email,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'discount' => $request->discount,
            ]);

            try {
                $data = [
                    'title' => 'Welcome to Our Travel Platform',
                    'password' => $password,
                    'email' => $email,
                    'login_url' => url('/login'),
                    'template' => 'user-invitation',
                ];

                Mail::to($email)->send(new SendMail($data));
            } catch (\Exception $e) {
                Log::error('Email failed to send: '.$e->getMessage());
            }
        });

        return redirect()->route('admin.travel-companies.index')->with('success', 'Travel Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'discount',
            4 => 'status',
            5 => 'action',
        ];

        $totalData = User::role('travel-company')->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = User::role('travel-company')
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = User::role('travel-company')->count();
        } else {
            $search = $request->input('search.value');
            $posts = User::role('travel-company')
                ->where('name', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = User::role('travel-company')
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
                $nestedData['discount'] = $r->travelCompany->discount ?? '0%';
                $nestedData['status'] = $r->is_active ? '<span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium">Active</span>' : '<span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium">Inactive</span>';
                $nestedData['action'] = '<a class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center"  href='.route('admin.travel-companies.edit', $r->id).'> <iconify-icon icon="lucide:edit"></iconify-icon></a>&nbsp;&nbsp<a class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"  onClick="deleteUser('.$r->id.')"> <iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a>';
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $travelCompany = $user->travelCompany;

        return view('admin.users.travel-companies.edit', compact('travelCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $travelCompany = TravelCompany::with('user')->findOrFail($request->id);

        $travelCompany->update($request->only([
            'company_name',
            'email',
            'contact_number',
            'address',
        ]));

        $travelCompany->user->update([
            'name' => $request->company_name,
        ]);

        return redirect()
            ->route('admin.travel-companies.index')
            ->with('success', 'Travel Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $travelCompany = $user->travelCompany;

        DB::transaction(function () use ($travelCompany, $user) {
            $travelCompany->delete();
            $user->delete();
        });

        return response()->json(['success' => 'Travel Company deleted successfully.']);
    }
}
