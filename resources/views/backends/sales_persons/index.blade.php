<x-app-layout>
    @slot('styles')
        <style>
            .dataTables_filter {
                float: left;
            }
            .dataTables_length{
                float: right;
            }
        </style>
    @endslot
    @slot('scripts')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // DISPLAY DATATABLE
                var t = $('#sales_persons_table').DataTable({
                    processing: true,
                    serverSide: true, //aktifkan server-side
                    scrollX: true,
                    dom: `<'row'<'col-sm-6 mt-1 float-left'f><'col-sm-6 mt-1 pt-1 float-right'l>> <'row'<'col-sm-12'tr>> <'row'<'col-sm-6 float-left'i><'col-sm-6 mt-2 float-right'p>>`,
                    ajax: {
                        url: "{{ route('sales-persons.index') }}",
                        type: 'GET'
                    },
                    columnDefs: [
                        { targets: 0, className: "text-center", searchable: false, orderable: false, defaultContent: '' },
                    ],
                    columns: [
                        { data: null, name: null },
                        { data: 'SalesPersonName', name: 'SalesPersonName' },
                        { data: 'Address', name: 'Address' },
                        { data: 'ContactPerson', name: 'ContactPerson' },
                        // { data: 'action', name: 'action', searchable: false },
                    ],
                })

                t.on( 'order.dt search.dt', function () {
                    t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();
            })
        </script>
    @endslot

    @slot('contentHeader')
        Sales Person Lists
    @endslot

    @slot('breadcrumbs')
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Sales Persons</li>
        </ol>
    @endslot

    <div class="card px-5 py-4">
        <div class="row">
            {{-- <div class="col-sm-12">
                <div class="float-right">
                    <div>
                        <a href="javascript:void(0)" class="btn btn-info" id="tombol-tambah"><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="dropdown-divider"></div>
        {{-- Awal Table --}}
        <table class="table table-striped table-bordered table-sm nowrap" style="width:100%" id="sales_persons_table">
            <thead>
                <tr>
                    <th style="width: 3em">#</th>
                    <th>Sales Person Name</th>
                    <th>Address</th>
                    <th style="width: 30em">Contact Person</th>
                    {{-- <th style="width: 15em">Actions</th> --}}
                </tr>
            </thead>
        </table>
        {{-- Akhir table --}}
    </div>
</x-app-layout>