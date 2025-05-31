<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelCompanyRequest;
use App\Http\Requests\UpdateTravelCompanyRequest;
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
            ]);

            try {
                $data = [
                    'title' => 'Welcome to Our Travel Platform',
                    'password' => $password,
                    'email' => $email,
                    'login_url' => url('/login'),
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
            3 => 'status',
            4 => 'action',
        ];

        $totalData = User::count();
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
            $totalFiltered = User::count();
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
                $nestedData['status'] = $r->is_active ? '<span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium">Active</span>' : '<span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium">Inactive</span>';
                $nestedData['action'] = '<a class="btn btn-outline-lilac-600 radius-8 px-20 py-11"  href='.route('admin.travel-companies.edit', $r->id).'> <i class="fas fa-trash"></i> Edit</a>&nbsp;&nbsp<a class="btn btn-outline-danger-600 radius-8 px-20 py-11"  onClick="deleteUser('.$r->id.')"> <i class="fas fa-trash"></i> Delete</a>';
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

        if (! $travelCompany) {
            return redirect()->route('admin.travel-companies.index')->with('error', 'Travel Company not found.');
        }

        return view('admin.users.travel-companies.edit', compact('travelCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTravelCompanyRequest $request)
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
            'email' => $request->email,
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
