@extends('layouts.app')

@section('content')
<div>
    <div class="d-flex justify-content-end align-items-center">
        <div class="me-auto h1">
            Notes
        </div>

        <form class="w-25 me-2">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Any keyword.." aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Search
                </button>
            </div>
        </form>

        <div class="flex-shrink-0 dropdown me-2">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-primary">
                    <i class="fa-solid fa-table-cells"></i>
                </button>
                <button type="button" class="btn btn-outline-primary">
                    <i class="fa-solid fa-list"></i>
                </button>
            </div>
        </div>

        <button type="button" class="btn btn-primary rounded-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Add New
        </button>
    </div>
</div>

<div class="mt-2">
    <ul class="list-group">
        <ul class="list-group-item list-group-item-action d-none d-lg-inline-block border-bottom bg-light">
            <div class="row fw-bold">
                <div class="col-1 d-flex align-items-center text-center">#</div>
                <div class="col-2 d-flex align-items-center">Name</div>
                <div class="col-5 d-flex align-items-center">Description</div>
                <div class="col-2 d-flex flex-row-reverse align-items-center text-end">Last Updated</div>
                <div class="col-2 d-flex flex-row-reverse align-items-center text-end">Action</div>
            </div>
        </ul>
        @if(!empty($notes) && $notes->count())
        @foreach($notes as $key => $note)
        <a href="#" class="list-group-item list-group-item-action">
            <div class="row">
                <div class="col-1 d-flex align-items-center text-center">{{ $notes->firstItem() + $key }}</div>
                <div class="col-2 d-flex align-items-center">{{ $note->name }}</div>
                <div class="col-5 d-flex align-items-center text-truncate">{{ $note->description }}</div>
                <div class="col-2 d-flex flex-row-reverse align-items-center text-end">{{ \Carbon\Carbon::parse($note->updated_at)->format('d-m-Y H:i')}}</div>
                <div class="col-2 d-flex flex-row-reverse align-items-center text-end">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{$note->id}}">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{$note->id}}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$note->id}}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
        @else
        <a href="#" class="list-group-item list-group-item-action">
            <div class="row">
                <div class="col-12">No note found.</div>
            </div>
        </a>
        @endif
    </ul>

    <div class="d-flex justify-content-center mt-3">
        <!-- Showing {{ $notes->firstItem() }} to {{ $notes->lastItem() }} of {{ $notes->total() }} notes -->
        {!! $notes->links() !!}
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input class="form-control border-0 rounded-0 shadow-none" type="text" name="name" placeholder="Title">
                    <textarea class="form-control border-0 rounded-0 shadow-none" name="description" id="exampleFormControlTextarea1" placeholder="Lorem ipsum.." rows="5"></textarea>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  -->
@foreach($notes as $note)
<div class="modal fade" id="viewModal{{$note->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $note->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-end d-none">
                    <button type="button" class="btn btn-info">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                </div>
                <div>
                    <p class="mb-0">
                        {{ $note->description }}
                    </p>
                </div>
                <div class="mt-4">
                    <small class="text-muted">
                        Last Updated: {{ $note->updated_at }}
                    </small>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
<!--  -->
@foreach($notes as $note)
<div class="modal fade" id="editModal{{$note->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('notes.update', $note->id ) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input class="form-control border-0 rounded-0 shadow-none" type="text" name="name" placeholder="Title" value="{{ $note->name }}">
                    <textarea class="form-control border-0 rounded-0 shadow-none" name="description" id="exampleFormControlTextarea1" placeholder="Lorem ipsum.." rows="5">{{ $note->description }}</textarea>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!--  -->
@foreach($notes as $note)
<div class="modal fade" id="deleteModal{{$note->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                Are you sure to proceed to delete this note?
                <p class="mt-4">
                    <a class="text-white bg-secondary h6 py-2 px-2 text-decoration-none rounded-2 text-monospace">
                        {{ $note->name }}
                    </a>
                </p>
            </div>
            <form method="POST" action="{{ route('notes.destroy', $note->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection