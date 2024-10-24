@extends('backend.layout.master-admin')

@section('content')
@include('backend.components.alert')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Give Permission: <span>{{ $role->name }}</span></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Permission</li>
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
                        <div class="card mt-5">
                            <div class="card-header d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h3 class="card-title">Give Permission</h3>
                                </div>
                                <div>
                                    <a href="{{ route('role.index') }}" class="btn btn-success float-end">Back</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('giv.permission', $role->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        @foreach ($permission as $per)
                                            <div class="col-md-2">
                                                <label>
                                                    <input type="checkbox" value="{{ $per->name }}" name="permission[]"
                                                        {{ in_array($per->id, $rolePermission) ? 'checked' : '' }} />
                                                    {{ $per->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="my-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
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
