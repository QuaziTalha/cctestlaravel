@extends('Components.AdminLayout')
@section('content')

<!-- Main Content -->
<div class="card">
    <div class="card-header">
        <h4 class="m-0">School List</h4>
    </div>
</div>

<!-- Data Tabel -->
<div class="card mt-3">
    <div class="card-header">
        <h5>All School Lists</h5>
    </div>
    <hr class="m-0">
    <div class="card-body">
        <table id="datatable" class="datatables-basic table table-bordered text-center">
            <thead>
                <tr>
                    <th>School Name</th>
                    <th>School Type</th>
                    <th>Syllabus Pattern</th>
                    <th>School Medium</th>
                    <th>School Address</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- Data Tabel -->
<!-- Main Content -->

<!-- Main Scipt -->
<script>
$(document).ready(function() {
    GetSchoolData()
})
function GetSchoolData() {
    // var from_date = "";
    // var to_date = "";
    // if ($('#start_date').val() != '' && $('#end_date').val() != '') {
    //     var from_date = $('#start_date').val();
    //     var to_date = $('#end_date').val();
    // }
    // $('#datatable').DataTable().destroy();
    var dataTables = $('#datatable').DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('GetSchoolList') }}",
            // data: {
            //     from_date: from_date,
            //     to_date: to_date,
            // },
        },
        columns: [{
                data: 'school_name',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'school_type',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'syllabus_pattern',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'school_medium',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'school_address ',
                "searchable": true,
                "orderable": false,
            },
            {
                data: 'actions',
                "searchable": true,
                "orderable": false,
            },
        ]
    });
}
</script>
<!-- Main Scipt -->
@endsection();