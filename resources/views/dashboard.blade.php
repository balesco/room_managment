@extends('layouts.app')
@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                            <li class="breadcrumb-item active">Calendar</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Calendar</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            @forelse ($rooms as $item)
                @php
                    $reservations = $item->reservations;
                @endphp
                <div class="col-md-4">
                    <div
                        class="card {{ $reservations->count() == 0 ? 'bg-secondary' : null }} {{ $reservations->where('date', '>=', date('Y-m-d'))->count() > 0 ? ($reservations->where('date', '=', date('Y-m-d'))->count() > 0 ? 'bg-danger' : 'bg-warning') : 'bg-info' }} text-white">
                        <div class="card-body">
                            <a class="text-white" href="{{ route('rooms.show', $item) }}">
                                <h4 class="card-title text-center">Salle : {{ $item->name }} </h4>
                                <h5 class="card-text text-center">Reservations :
                                    {{ $item->reservations->where('date', '>=', date('Y-m-d'))->count() }}
                                </h5>
                            </a>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            @empty

            @endforelse
        </div>
        <!-- end row -->
    </div> <!-- End Content -->
@endsection
