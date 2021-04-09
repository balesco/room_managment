@extends('layouts.app')
@push('style')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <table id="datatable-buttons" class="table dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date de création</th>
                <th>Reserv (en cours et futurs)</th>
                <th>Occupé?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rooms as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td class="text-center">{{ $item->reservations->where('date', '>=', date('Y-m-d'))->count() }}</td>
                    <td>
                        <!-- Switch-->
                        <div>
                            <input type="checkbox" id="switch1"
                                {{ $item->reservations->where('date', '=', date('Y-m-d'))->count() > 0 ? 'checked' : null }}
                                data-switch="success" disabled />
                            <label for="switch1" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('rooms.edit', $item) }}" class="btn btn-primary">
                                <i class="dripicons-pencil"></i>
                            </a>
                            <a href="{{ route('rooms.show', $item) }}" class="btn btn-info mx-1">
                                <i class="dripicons-preview"></i>
                            </a>
                            <form action="{{ route('rooms.destroy', $item) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">
                                    <i class="dripicons-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>
@endsection
@push('script')
    <!-- Datatables js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable Init js -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
@endpush
