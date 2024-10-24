@extends('backend.layout.master-admin')
@section('content')
@include('backend.components.alert')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create User</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-5">
                            <div class="card-header d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h3 class="card-title">Create User & Define Role</h3>
                                </div>
                                <div>
                                    <a href="{{ route('user.index') }}" class="btn btn-dark btn-sm">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name">User Name <span class="text-danger">*</span></label>
                                        <input required type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" placeholder="Enter user name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email">User Email <span class="text-danger">*</span></label>
                                        <input required type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" placeholder="Enter user email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password">User Password <span class="text-danger">*</span></label>
                                        <input required type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" placeholder="Enter user password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="roles">User Role <span class="text-danger"><span class="text-danger">*</span></span></label>
                                        <select required name="roles[]" data-placeholder="Select a State" multiple="muliple" id="roles" class="form-control select2 @error('roles') is-invalid @enderror" style="width: 100%">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ in_array($role, old('roles', [])) ? 'selected' : '' }}>
                                                    {{ $role }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
