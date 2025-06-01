<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class ManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.hotel-managers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.hotel-managers.create');
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

        $existingManager = $hotel->users()->role('hotel-manager')->first();

        if ($existingManager) {
            return redirect()->back()->withErrors(['hotel_id' => 'This hotel already has a manager assigned.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword,
        ]);

        $user->assignRole('hotel-manager');
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
            Log::error('Email failed to send: ' . $e->getMessage());
        }

        return redirect()->route('admin.managers.index')->with('success', 'Hotel manager created successfully.');
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

        $totalData = User::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = User::role('hotel-manager')
                ->with('hotels')
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();

            $totalFiltered = User::role('hotel-manager')->count();
        } else {
            $search = $request->input('search.value');

            $posts = User::role('hotel-manager')
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

            $totalFiltered = User::role('hotel-manager')
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
                $nestedData['action'] = '<a class="btn btn-outline-lilac-600 radius-8 px-20 py-11"  href=' . route('admin.managers.edit', $r->id) . '> <i class="fas fa-trash"></i> Edit</a>&nbsp;&nbsp<a class="btn btn-outline-danger-600 radius-8 px-20 py-11"  onClick="deleteUser(' . $r->id . ')"> <i class="fas fa-trash"></i> Delete</a>';
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
    public function edit($id)
    {
        $manager = User::findOrFail($id);
        $hotel = $manager->hotels()->first();

        if (! $hotel) {
            return redirect()->route('admin.manager.index')->withErrors(['hotel_id' => 'This user is not assigned to any hotel.']);
        }

        return view('admin.users.hotel-managers.edit', compact('manager', 'hotel'));
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

        $manager = User::findOrFail($request->id);
        $hotel = Hotel::findOrFail($request->hotel_id);

        $currentHotelId = $manager->hotels()->first()?->id;

        if ($currentHotelId != $hotel->id) {
            $existingManager = $hotel->users()
                ->role('hotel-manager')
                ->where('users.id', '!=', $manager->id)
                ->first();

            if ($existingManager) {
                return redirect()->back()->withErrors(['hotel_id' => 'This hotel already has a manager assigned.']);
            }
        }

        $manager->name = $request->name;
        $manager->email = $request->email;
        $manager->save();

        $manager->hotels()->sync([$hotel->id]);

        return redirect()->route('admin.managers.index')->with('success', 'Hotel Manager updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $manager = User::findOrFail($request->id);

        if ($manager->hasRole('hotel-manager')) {
            $manager->hotels()->detach();
            $manager->delete();

            return response()->json(['success' => 'Hotel Manager deleted successfully.']);
        }

        return response()->json(['error' => 'User is not a hotel manager.'], 403);
    }
}
