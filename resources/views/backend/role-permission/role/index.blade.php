@extends('backend.layout.master-admin')
@section('content')
    @include('backend.components.alert')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Role</li>
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
                                    <h3 class="card-title">Show role</h3>
                                </div>
                                <div>
                                    <a href="{{ route('role.create') }}" class="btn btn-primary btn-sm">Add New</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>NO:</th>
                                            <th>Role Name</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $role)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->created_at }}</td>
                                                <td>
                                                      <a href="{{route('add.permission',$role->id)}}" class="btn btn-success">Add/Edit Role & Permission</a>
                                                    {{-- @can('edit role') --}}
                                                    <a href="{{ route('role.edit', $role->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    {{-- @endcan --}}
                                                    {{-- @can('delete role') --}}
                                                    <a type="button" onclick="confirmDelete(event, {{ $role->id }})"
                                                        href="javascript:void(0)" class="btn btn-danger btn-sm tableEdit">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                    <!-- Delete form -->
                                                    <form id="delete-form-{{ $role->id }}"
                                                        action="{{ route('role.destroy', $role->id) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    {{-- @endcan --}}
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
@section('js')
    <script>
        function confirmDelete(event, roleId) {
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
                    $("#delete-form-" + roleId).submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    console.log('User cancelled deletion');
                }
            });
        }
    </script>
@endsection
