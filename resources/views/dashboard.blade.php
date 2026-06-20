<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wydarzenia Sportowe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Sukces!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Błąd!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Lista nadchodzących wydarzeń</h3>
                    @if(auth()->user()->role === 'organizator')
                        <div class="mb-4">
                            <a href="{{ route('events.create') }}" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                                + Dodaj Wydarzenie
                            </a>
                        </div>
                    @endif

                    @if(auth()->user()->role === 'admin')
                        <div class="mb-4">
                            <a href="{{ route('users.index') }}" class="bg-purple-500 hover:bg-purple-700 text-black font-bold py-2 px-4 rounded">
                                Zarządzaj Użytkownikami (Admin)
                            </a>
                        </div>
                    @endif
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nazwa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Miejsca</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcja</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($events as $event)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->event_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $event->registrations()->count() }} / {{ $event->capacity }}
                                    </td>
                                     <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $isRegistered = \App\Models\Registration::where('user_id', Auth::id())->where('event_id', $event->id)->exists();
                                        @endphp

                                        @if($isRegistered)
                                            <form action="{{ route('events.unregister', $event->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-vlack font-bold py-2 px-4 rounded">
                                                    Wypisz się
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('events.register', $event->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                                    Zapisz się
                                                </button>
                                            </form>
                                        @endif
                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">Brak wydarzeń w systemie.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>