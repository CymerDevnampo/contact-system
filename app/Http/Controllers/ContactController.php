<?php

namespace App\Http\Controllers;

use App\Address;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('address')->where('user_id', Auth::id())->paginate(5);
        return view('index', compact('contacts'));

        // return response()->json([
        //     'contacts' => $contacts,
        // ]);
    }


    public function createContact()
    {
        return view('contacts.create');
    }

    public function storeContact(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:contacts,email,NULL,id,user_id,' . Auth::id(),
            'address' => 'required|string|max:255',
        ]);

        // Find or create the address
        $address = Address::firstOrCreate([
            'user_id' => Auth::id(),
            'address' => $request->address,
        ]);

        // Create the contact and associate it with the address
        $validatedData['user_id'] = Auth::id();
        $validatedData['address_id'] = $address->id; // Associate the address_id
        $contact = Contact::create($validatedData);

        return redirect()->route('/')->with('success', 'Contact created successfully.');
    }

    public function show($id)
    {
        $contact = Contact::where('user_id', Auth::id())->findOrFail($id);
        return view('contacts.show', compact('contact'));
    }

    public function editContact($id)
    {
        $contact = Contact::where('user_id', Auth::id())->findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    public function updateContact(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'company' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:15',
            'email' => 'sometimes|required|email',
        ]);

        $existingContact = Contact::where('user_id', Auth::id())
            ->where('email', $request->email)
            ->where('id', '!=', $id)
            ->first();

        if ($existingContact) {
            return back()->withInput()->withErrors(['email' => 'This email is already taken for your account.']);
        }

        $contact = Contact::where('user_id', Auth::id())->findOrFail($id);
        $contact->update($validatedData);
        sleep(3);
        return redirect()->route('/')->with('success', 'Contact updated successfully.');
    }

    public function destroyContact($id)
    {
        $contact = Contact::where('user_id', Auth::id())->findOrFail($id);
        $contact->delete();
        sleep(3);
        return redirect()->route('/')->with('success', 'Contact deleted successfully.');
    }

    public function searchContacts(Request $request)
    {
        $query = $request->input('query');

        $contacts = Contact::where('user_id', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('company', 'LIKE', "%{$query}%")
                    ->orWhere('phone', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->paginate(5);

        return response()->json(view('partials.contacts_table', compact('contacts'))->render());
    }


}
