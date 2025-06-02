<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ClerksController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-hotel-clerks', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-hotel-clerks', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-hotel-clerks', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-hotel-clerks', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.hotel-clerks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.hotel-clerks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $password = random_int(10000000, 99999999);
        $hashedPassword = Hash::make($password);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'hotel_id' => 'required|exists:hotels,id',
        ]);

        $hotel = Hotel::findOrFail($request->hotel_id);

        $existingClerk = $hotel->users()->role('hotel-clerk')->first();

        if ($existingClerk) {
            return redirect()->back()->withErrors(['hotel_id' => 'This hotel already has a clerk assigned.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword,
        ]);

        $user->assignRole('hotel-clerk');

        $user->hotels()->attach($request->hotel_id);

        try {
            $data = [
                'title' => 'Welcome to Our Hotel Platform',
                'password' => $password,
                'email' => $user->email,
                'login_url' => url('/login'),
            ];

            Mail::to($user->email)->send(new SendMail($data));
        } catch (\Exception $e) {
            Log::error('Email failed to send: '.$e->getMessage());
        }

        return redirect()->route('admin.hotel-clerks.index')->with('success', 'Hotel Clerk created successfully.');
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
            3 => 'hotel',
            4 => 'status',
            5 => 'action',
        ];

        $totalData = User::role('hotel-clerk')->count();
        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $posts = User::role('hotel-clerk')
                ->with('hotels')
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();

            $totalFiltered = User::role('hotel-clerk')->count();
        } else {
            $search = $request->input('search.value');

            $posts = User::role('hotel-clerk')
                ->with('hotels')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('hotels', function (Builder $q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();

            $totalFiltered = User::role('hotel-clerk')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('hotels', function (Builder $q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                })
                ->count();
        }

        $data = [];

        if ($posts) {
            foreach ($posts as $r) {
                $nestedData['id'] = $r->id;
                $nestedData['name'] = $r->name;
                $nestedData['email'] = $r->email;
                $nestedData['hotel'] = $r->hotels()->first() ? $r->hotels()->first()->name : 'No Hotel Assigned';
                $nestedData['status'] = $r->is_active ? '<span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium">Active</span>' : '<span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium">Inactive</span>';
                $nestedData['action'] = '<a class="btn btn-outline-lilac-600 radius-8 px-20 py-11"  href='.route('admin.hotel-clerks.edit', $r->id).'> <i class="fas fa-trash"></i> Edit</a>&nbsp;&nbsp<a class="btn btn-outline-danger-600 radius-8 px-20 py-11"  onClick="deleteUser('.$r->id.')"> <i class="fas fa-trash"></i> Delete</a>';
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
        $clerk = User::findOrFail($id);
        $hotel = $clerk->hotels()->first();

        return view('admin.users.hotel-clerks.edit', compact('clerk', 'hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($request->id),
            ],
            'hotel_id' => 'required|exists:hotels,id',
        ]);

        $clerk = User::findOrFail($request->id);
        $hotel = Hotel::findOrFail($request->hotel_id);

        $currentHotelId = $clerk->hotels()->first()?->id;

        if ($currentHotelId != $hotel->id) {
            $existingClerk = $hotel->users()
                ->role('hotel-clerk')
                ->where('users.id', '!=', $clerk->id)
                ->first();

            if ($existingClerk) {
                return redirect()->back()->withErrors(['hotel_id' => 'This hotel already has a clerk assigned.']);
            }
        }

        $clerk->name = $request->name;
        $clerk->email = $request->email;
        $clerk->save();

        $clerk->hotels()->sync([$hotel->id]);

        return redirect()->route('admin.hotel-clerks.index')->with('success', 'Hotel Clerk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $clerk = User::findOrFail($request->id);

        if ($clerk->hasRole('hotel-clerk')) {
            $clerk->hotels()->detach();
            $clerk->delete();

            return response()->json(['success' => 'Hotel Clerk deleted successfully.']);
        }

        return response()->json(['error' => 'User is not a hotel clerk.'], 403);
    }
}
