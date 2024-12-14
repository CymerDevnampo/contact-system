{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-end" align="right">
            <a href="/create">Add Contact</a> |
            <a href="" class="active">Contacts</a> |
            <a href="">Logout</a>
        </div>
        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand">Contacts</a>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->company }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection --}}
