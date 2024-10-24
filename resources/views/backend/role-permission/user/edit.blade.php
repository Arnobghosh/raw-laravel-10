@extends('backend.layout.master-admin')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
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
                                    <h3 class="card-title">Edit User & Define Role</h3>
                                </div>
                                <div>
                                    <a href="{{ route('user.index') }}" class="btn btn-dark btn-sm">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- User Name -->
                                    <div class="mb-3">
                                        <label for="name">User Name</label>
                                        <input type="text" value="{{ old('name', $user->name) }}"
                                            class="form-control @error('name') is-invalid @enderror" name="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- User Email (Read-only) -->
                                    <div class="mb-3">
                                        <label for="email">User Email</label>
                                        <input value="{{ old('email', $user->email) }}" readonly type="text"
                                            class="form-control @error('email') is-invalid @enderror" name="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- User Password -->
                                    <div class="mb-3">
                                        <label for="password">User Password</label>
                                        <input type="text" class="form-control @error('password') is-invalid @enderror"
                                            name="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- User Role -->
                                    <div class="mb-3">
                                        <label for="roles">User Role</label>
                                        <select data-placeholder="Select a role" name="roles[]" multiple
                                            class="form-control select2 @error('roles') is-invalid @enderror">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ in_array($role, old('roles', $userRole)) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
