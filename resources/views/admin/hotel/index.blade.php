@extends('layouts.admin.app')

@section('content')
    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title mb-0">Manage Hotels</h5>
            <a href="{{ route('admin.hotels.create') }}" class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">Add New Hotel</a>
        </div>
        <div class="card-body">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th>
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">#</label>
                            </div>
                        </th>
                        <th>Hotel Name</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($hotels) --}}
                    @forelse($hotels as $index => $hotel)
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">{{ $index + 1 }}</label>
                                </div>
                            </td>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->phone }}</td>
                            <td>{{ $hotel->type->label() }}</td>
                            <td>{{ $hotel->country ?? 'N/A' }}</td>
                            <td>
                                <span class="px-24 py-4 rounded-pill fw-medium text-sm 
                                    {{ $hotel->active ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">
                                    {{ $hotel->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="d-flex gap-2 items-center">
                                <a href="#"
                                   class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                </a>
                                <a href="{{ route('admin.hotels.edit', $hotel->id) }}"
                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center border-0"
                                            onclick="return confirm('Are you sure you want to delete this hotel?')">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No Hotels Stored Yet To Display.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
