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

        <form method="post" action="/store-contact" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                        name="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label>Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Address"
                        name="address">
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label>Company</label>
                    <input type="text" class="form-control @error('company') is-invalid @enderror" placeholder="Company"
                        name="company">
                    @error('company')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label>Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone"
                        name="phone">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label>Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                        name="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <button class="btn btn-primary" type="submit" onclick="submitForm()">Add Contact</button>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function submitForm() {
            Swal.fire({
                icon: 'info',
                title: 'Processing...',
                text: "Please wait...",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 1500
            });
            setTimeout(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Added Successfully.',
                    timer: 1500
                });
            }, 1500);
        }
    </script>
@endpush

@push('css')
    <style>
        .justify-content-end a.active {
            color: black;
        }
    </style>
@endpush
