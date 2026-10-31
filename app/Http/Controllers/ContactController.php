<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = auth()->user()->contacts();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($group = $request->get('group')) {
            $query->where('group', $group);
        }

        if ($request->get('favorites')) {
            $query->where('is_favorite', true);
        }

        $contacts = $query->orderBy('name')->paginate(15)->withQueryString();
        $groups = auth()->user()->contacts()->whereNotNull('group')->distinct()->pluck('group');

        return view('contacts.index', compact('contacts', 'groups'));
    }

    public function create()
    {
        $groups = auth()->user()->contacts()->whereNotNull('group')->distinct()->pluck('group');
        return view('contacts.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'phone'     => 'nullable|string|max:30',
            'company'   => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'address'   => 'nullable|string',
            'group'     => 'nullable|string|max:100',
            'notes'     => 'nullable|string',
        ]);
        $validated['is_favorite'] = $request->boolean('is_favorite');

        auth()->user()->contacts()->create($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact created.');
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);
        $groups = auth()->user()->contacts()->whereNotNull('group')->distinct()->pluck('group');
        return view('contacts.edit', compact('contact', 'groups'));
    }

    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'phone'     => 'nullable|string|max:30',
            'company'   => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'address'   => 'nullable|string',
            'group'     => 'nullable|string|max:100',
            'notes'     => 'nullable|string',
        ]);
        $validated['is_favorite'] = $request->boolean('is_favorite');

        $contact->update($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact updated.');
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted.');
    }

    public function toggleFavorite(Contact $contact)
    {
        $this->authorize('update', $contact);
        $contact->update(['is_favorite' => !$contact->is_favorite]);
        return back()->with('success', $contact->is_favorite ? 'Added to favorites.' : 'Removed from favorites.');
    }
}
