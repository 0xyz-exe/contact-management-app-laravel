<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $contact->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('contacts.edit', $contact) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                <a href="{{ route('contacts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Back</a>
            </div>
        </div>
    </x-slot>
    <div class="py-12"><div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>@endif
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-3">
            @if($contact->is_favorite)<p class="text-yellow-500 text-xl">★ Favorite</p>@endif
            @if($contact->job_title || $contact->company)<p class="text-gray-600">{{ collect([$contact->job_title, $contact->company])->filter()->implode(' @ ') }}</p>@endif
            @if($contact->email)<p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}" class="text-blue-600">{{ $contact->email }}</a></p>@endif
            @if($contact->phone)<p><strong>Phone:</strong> <a href="tel:{{ $contact->phone }}" class="text-blue-600">{{ $contact->phone }}</a></p>@endif
            @if($contact->address)<p><strong>Address:</strong> {{ $contact->address }}</p>@endif
            @if($contact->group)<p><strong>Group:</strong> <span class="px-2 py-1 bg-blue-100 text-blue-800 text-sm rounded">{{ $contact->group }}</span></p>@endif
            @if($contact->notes)<p><strong>Notes:</strong><br>{{ $contact->notes }}</p>@endif
            <p class="text-xs text-gray-400">Added {{ $contact->created_at->format('M d, Y') }}</p>
            <div class="flex gap-2 pt-2">
                <form action="{{ route('contacts.favorite', $contact) }}" method="POST"><@csrf<button type="submit" class="text-sm {{ $contact->is_favorite ? 'text-yellow-600' : 'text-gray-500' }} hover:underline">{{ $contact->is_favorite ? 'Remove from Favorites' : 'Add to Favorites' }}</button></form>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Delete this contact?')">@csrf @method('DELETE')<button type="submit" class="text-sm text-red-600 hover:underline">Delete</button></form>
            </div>
        </div>
    </div></div>
</x-app-layout>
