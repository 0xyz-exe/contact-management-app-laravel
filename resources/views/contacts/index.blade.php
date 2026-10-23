<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contacts</h2>
            <a href="{{ route('contacts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Contact</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>@endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="mb-4 flex gap-2 flex-wrap">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone, company..." class="flex-1 rounded-md border-gray-300 shadow-sm">
                    <select name="group" class="rounded-md border-gray-300 shadow-sm">
                        <option value="">All Groups</option>
                        @foreach($groups as $group)<option value="{{ $group }}" {{ request('group') === $group ? 'selected' : '' }}>{{ $group }}</option>@endforeach
                    </select>
                    <label class="flex items-center gap-1 text-sm"><input type="checkbox" name="favorites" value="1" {{ request('favorites') ? 'checked' : '' }}> Favorites</label>
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                    @if(request()->hasAny(['search','group','favorites']))<a href="{{ route('contacts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Clear</a>@endif
                </form>

                @if($contacts->isEmpty())
                    <p class="text-gray-500 text-center py-8">No contacts found.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($contacts as $contact)
                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-semibold text-lg">{{ $contact->name }}</h3>
                                    @if($contact->job_title || $contact->company)
                                        <p class="text-sm text-gray-500">{{ collect([$contact->job_title, $contact->company])->filter()->implode(' @ ') }}</p>
                                    @endif
                                </div>
                                <form action="{{ route('contacts.favorite', $contact) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="{{ $contact->is_favorite ? 'text-yellow-500' : 'text-gray-300' }} hover:text-yellow-500 text-xl">★</button>
                                </form>
                            </div>
                            @if($contact->email)<p class="text-sm text-gray-600">✉ {{ $contact->email }}</p>@endif
                            @if($contact->phone)<p class="text-sm text-gray-600">📞 {{ $contact->phone }}</p>@endif
                            @if($contact->group)<span class="inline-block mt-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">{{ $contact->group }}</span>@endif
                            <div class="mt-3 flex gap-2 text-sm">
                                <a href="{{ route('contacts.show', $contact) }}" class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('contacts.edit', $contact) }}" class="text-green-600 hover:underline">Edit</a>
                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $contacts->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
