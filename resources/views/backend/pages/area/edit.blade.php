@extends('backend.layout.master-admin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit Area</h5>
                        <a href="{{ route('area.index') }}" class="btn btn-primary btn-sm mb-10">Back</a>
                    </div>
                    <div class="card-body">
                        @include('backend.components.alert')

                        {!! Form::open(['route' => ['area.update', $info->id], 'method' => 'put', 'files' => true]) !!}

                        <div class="form-group mb-4">
                            <label>Area Name<span style="color: red;">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{ $info->name }}"
                                required="">
                        </div>

                        <div class="form-group mb-4">
                            <label>Note</label>
                            <input class="form-control" type="text" name="note" value="{{ old('note', $info->note) }}"
                                required="">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary mr-2" type="submit">Submit</button>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
