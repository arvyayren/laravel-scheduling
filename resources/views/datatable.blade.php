@extends('home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data User</div>

                <div class="card-body">
                    <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/ed352558c5.js" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function () {
    $('#tbl_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url()->current() }}',
        columns: [
            { data: 'Name', name: 'Name' },
            { data: 'age', name: 'age' },
            { data: 'Gender', name: 'Gender' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    })
})

function del(e) {
    var url = '{{ route("user.delete", ":id") }}'
    url = url.replace(':id', e)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    Swal.fire({
        title             : "Are you sure ?",
        text              : "Data after deleted cannot be restore",
        icon              : "warning",
        showCancelButton  : true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor : "#d33",
        confirmButtonText : "Yes!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url    : url,
                type   : "delete",
                success: function(data) {
                    $('#tbl_list').DataTable().ajax.reload();
                }
            })
        }
    })
}
</script>
@endpush