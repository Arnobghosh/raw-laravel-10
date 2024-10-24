@extends('backend.layout.master-admin')
@section('content')
    @include('backend.components.alert')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h3 class="card-title">Show User</h3>
                                </div>
                                <div>
                                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Add New</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>NO:</th>
                                            <th>User Name</th>
                                            <th>User Mail</th>
                                            <th>User Roles</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if (!empty($user->getRoleNames()))
                                                        @foreach ($user->getRoleNames() as $roleName)
                                                            <label for="rolenName"
                                                                class="badge bg-primary">{{ $roleName }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    {{-- <a href="{{ url('user/' . $user->id . '/delete') }}"
                                                        class="btn btn-danger">Delete</a> --}}

                                                         {{-- @endcan --}}
                                                    {{-- @can('delete role') --}}
                                                    <a type="button" onclick="confirmDelete(event, {{ $user->id }})"
                                                        href="javascript:void(0)" class="btn btn-danger btn-sm tableEdit">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                    <!-- Delete form -->
                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- /.content -->
    </div>
@endsection
@push('js')
    <script>
        function confirmDelete(event, userId) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $("#delete-form-" + userId).submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    console.log('User cancelled deletion');
                }
            });
        }
    </script>
@endpush

{{-- 
<table class="table table-primary">
    <thead>
        <tr>
            <th>NO:</th>
            <th>User Name</th>
            <th>User Mail</th>
            <th>User Roles</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $roleName)
                            <label for="rolenName" class="badge bg-primary">{{ $roleName }}</label>
                        @endforeach
                    @endif
                </td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <a href="{{ url('user/' . $user->id . '/edit') }}" class="btn btn-warning">Edit</a>
                    <a href="{{ url('user/' . $user->id . '/delete') }}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
</div>
@endsection --}} --}}
