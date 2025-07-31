@extends('backend.layout.master-admin')
@section('content')
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="box-title">Area List</h5>
                            <a href="{{ route('area.create') }}" class="btn btn-primary btn-sm mb-10">Add Area</a>
                        </div>
                        <div class="card-body">
                            <br>
                            @include('backend.components.alert')
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="dt-responsive">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Area Name</th>
                                            <th>Note</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td style="text-transform:capitalize;">{{ $value->name ?? '--' }}</td>
                                                <td style="text-transform:capitalize;">{{ $value->note ?? '--' }}</td>
                                                <td>
                                                    <label class="ui-switch switch-solid switch-success"><input
                                                            type="checkbox"
                                                            onchange="changestatus(event, <?php echo $value->id; ?>)"
                                                            <?php if ($value->status == 1) {
                                                                echo 'checked';
                                                            } else {
                                                                echo '';
                                                            } ?>><span></span></label>
                                                </td>
                                                <td>
                                                    <div style="display: flex;gap:10px">
                                                        <a href="{{ route('area.edit', $value->id) }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                        <form method="POST"
                                                            action="{{ route('area.destroy', $value->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure to delete this categroy')">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <!-- END: Page content-->
@endsection
@section('script')
    <script type="text/javascript">
        function changestatus(event, id) {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url': "{{ url('/changeAreastatus') }}",
                'type': 'post',
                'dataType': 'text',
                data: {
                    id: id
                },
                success: function(data) {
                    Swal.fire({
                        title: "Thanks!",
                        text: 'Status Change Successfully.',
                        type: "success"
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                    return false;
                }
            });
        }
    </script>
@endsection
