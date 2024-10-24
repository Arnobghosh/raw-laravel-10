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
                    <!-- left column -->
                    <div class="col-md-8">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h3 class="card-title">Crate Role</h3>
                                </div>
                                <div>
                                    <a href="{{ route('role.index') }}" class="btn btn-dark btn-sm">Back</a>
                                </div>
                            </div>

                            <!-- form start -->
                            <form action="{{ route('role.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="role_name">Role Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="role_name"
                                            placeholder="Enter name" value="{{ old('name') }}" required>

                                        <!-- Error message -->
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6">

                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <!-- /.content -->
    </div>
@endsection

{{-- @extends('backend.layout.master-admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card mt-5">
                <div class="card-header">
                    <h3>Role
                        <a href="{{ url('/role') }}" class="btn btn-success float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/role') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
