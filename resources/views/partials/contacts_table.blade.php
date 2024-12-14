<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Name</th>
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
