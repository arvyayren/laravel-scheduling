@extends('report.report')

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
                            <th>Date</th>
                            <th>Male Count</th>
                            <th>Female Count</th>
                            <th>Male Average Age</th>
                            <th>Female Average Age</th>
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
<script type="text/javascript">
$(document).ready(function () {
   $('#tbl_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url()->current() }}',
        columns: [
            { data: 'date', name: 'date' },
            { data: 'male_count', name: 'male_count' },
            { data: 'female_count', name: 'female_count' },
            { data: 'male_avg_age', name: 'male_avg_age' },
            { data: 'female_avg_age', name: 'female_avg_age' },
        ]
    });
 });
</script>
@endpush