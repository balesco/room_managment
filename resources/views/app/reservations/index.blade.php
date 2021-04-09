<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.reservations.index_title')
        </h2>
    </x-slot>
    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <div class="mb-5 mt-4">
                        <div class="flex flex-wrap justify-between">
                            <div class="md:w-1/2">
                                <form>
                                    <div class="d-flex items-center w-full">
                                        <x-inputs.text name="search" value="{{ $search ?? '' }}"
                                            placeholder="{{ __('crud.common.search') }}" autocomplete="off">
                                        </x-inputs.text>

                                        <div class="ml-1">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="icon ion-md-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="md:w-1/2 text-right">
                                @can('create', App\Models\Reservation::class)
                                    <a href="{{ route('reservations.create') }}" class="btn mx-2 btn-primary">
                                        <i class="mr-1 icon ion-md-add"></i>
                                        @lang('crud.common.create')
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="block w-full overflow-auto scrolling-touch">
                        {{-- <table class="w-full max-w-full mb-4 bg-transparent">
                            <thead class="text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left">
                                        @lang('crud.reservations.inputs.date')
                                    </th>
                                    <th class="px-4 py-3 text-left">
                                        @lang('crud.reservations.inputs.begin_at')
                                    </th>
                                    <th class="px-4 py-3 text-left">
                                        @lang('crud.reservations.inputs.end_at')
                                    </th>
                                    <th class="px-4 py-3 text-left">
                                        @lang('crud.reservations.inputs.description')
                                    </th>
                                    <th class="px-4 py-3 text-left">
                                        @lang('crud.reservations.inputs.user_id')
                                    </th>
                                    <th class="px-4 py-3 text-left">
                                        @lang('crud.reservations.inputs.room_id')
                                    </th>
                                    <th class="px-4 py-3 text-right">
                                        @lang('crud.common.actions')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @forelse($reservations as $reservation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-left">
                                            {{ $reservation->date ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $reservation->begin_at ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $reservation->end_at ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ $reservation->description ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ optional($reservation->user)->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-left">
                                            {{ optional($reservation->room)->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center" style="width: 134px;">
                                            <div role="group" aria-label="Row Actions"
                                                class="relative inline-flex align-middle">
                                                @can('update', $reservation)
                                                    <a href="{{ route('reservations.edit', $reservation) }}" class="mr-1">
                                                        <button type="button" class="button">
                                                            <i class="icon ion-md-create"></i>
                                                        </button>
                                                    </a>
                                                    @endcan @can('view', $reservation)
                                                    <a href="{{ route('reservations.show', $reservation) }}" class="mr-1">
                                                        <button type="button" class="button">
                                                            <i class="icon ion-md-eye"></i>
                                                        </button>
                                                    </a>
                                                    @endcan @can('delete', $reservation)
                                                    <form action="{{ route('reservations.destroy', $reservation) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="button">
                                                            <i class="icon ion-md-trash text-red-600"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            @lang('crud.common.no_items_found')
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="mt-10 px-4">
                                            {!! $reservations->render() !!}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table> --}}
                        <table class="table table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>Créer le</th>
                                    <th>Salle</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Active?</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reservations as $item)
                                    <tr>
                                        <td>{{$item->created_at->format('Y-m-d')}}</td>
                                        <td>{{$item->room->name}}</td>
                                        <td>{{$item->user->name}}</td>
                                        <td>{{$item->date->format('Y/m/d')}}</td>
                                        <td>{{$item->begin_at}}</td>
                                        <td>{{$item->end_at}}</td>
                                        <td>
                                            <!-- Switch-->
                                            <div>
                                                <input type="checkbox" id="switch1" checked data-switch="success" />
                                                <label for="switch1" data-on-label="Yes" data-off-label="No"
                                                    class="mb-0 d-block"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-partials.card>
            </div>
        </div>
    @endsection
</x-app-layout>
