@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-end" align="right">
            <a href="/create" class="{{ Request::is('create') ? 'active' : '' }}">Add Contact</a> |
            <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Contacts</a> |
            @guest
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
            @else
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>
            @endguest

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand">Contacts</a>
            <form class="form-inline" id="searchForm">
                <input class="form-control mr-sm-2" type="search" id="search" placeholder="Search" aria-label="Search">
            </form>
        </nav>

        <div id="contactsTable">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Company</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->address->address ?? '' }}</td>
                            <td>{{ $contact->company }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="/edit-contact/{{ $contact->id }}" method="GET">
                                        <button type="submit" class="custom-edit-btn btn btn-sm bg-danger-light">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </form>
                                    <form id="deleteForm{{ $contact->id }}" action="/delete-contact/{{ $contact->id }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="custom-delete-btn btn btn-sm bg-success-light me-2"
                                            onclick="deleteButton('{{ $contact->id }}')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function deleteButton(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Processing...",
                        text: "Please wait...",
                        icon: "info",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById('deleteForm' + id).submit();
                        Swal.fire({
                            title: "Deleted!",
                            text: "...",
                            icon: "success",
                            timer: 1500
                        });
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();
                $.ajax({
                    url: "{{ route('search.contacts') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log('Success:', data);
                        $('#contactsTable').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .justify-content-end a.active {
            color: black;
        }
    </style>
@endpush
