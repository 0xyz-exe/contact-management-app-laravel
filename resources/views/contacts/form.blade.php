@php $editing = isset($contact); $action = $editing ? route('contacts.update', $contact) : route('contacts.store'); @endphp
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $editing ? 'Edit' : 'Add' }} Contact</h2></x-slot>
    <div class="py-12"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8"><div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <form action="{{ $action }}" method="POST">
            @csrf @if($editing) @method('PUT') @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $contact->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $contact->email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $contact->phone ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Company</label>
                    <input type="text" name="company" value="{{ old('company', $contact->company ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Job Title</label>
                    <input type="text" name="job_title" value="{{ old('job_title', $contact->job_title ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Group</label>
                    <input type="text" name="group" value="{{ old('group', $contact->group ?? '') }}" list="groups-list" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. Work, Family">
                    <datalist id="groups-list">@foreach($groups as $g)<option value="{{ $g }}">@endforeach</datalist>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('address', $contact->address ?? '') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $contact->notes ?? '') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                        <input type="checkbox" name="is_favorite" value="1" {{ old('is_favorite', $contact->is_favorite ?? false) ? 'checked' : '' }}> Mark as Favorite
                    </label>
                </div>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ $editing ? 'Update' : 'Save' }}</button>
                <a href="{{ route('contacts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</a>
            </div>
        </form>
    </div></div></div>
</x-app-layout>
