@extends('backend.layouts.app')
@section('PageTitle', 'Brands')
@section('content')
    <!--breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Brand</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx
                    bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Brand List</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb -->

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="ms-auto" style="margin-bottom: 20px">
                    <a href="brand/add" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i>Add New Brand</a></div>

                <table id="data_table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Brand Slug</th>
                        <th>View Details</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>

                </table>
            </div>
        </div>
    </div>
@endsection

@section('data-tables-script')
<script src="{{asset('assets')}}/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#data_table').DataTable({
            lengthChange: true,
            buttons: ['excel', 'pdf', 'print']
        });

        table.buttons().container()
            .appendTo('#data_table_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
