<x-app-layout>
    @slot('styles')
        <style>
            .dataTables_filter {
                float: left;
            }
            .dataTables_length{
                float: right;
            }
            .select2-selection {
                height: 2.6em !important;
            }
            .select2-selection__arrow {
                margin-top: .4em;
                margin-right: .4em;
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

                $('.select2').each(function () {
                    var $this = $(this)
                    $this.wrap('<div class="position-relative"></div>')
                    $this.select2({
                        // the following code is used to disable x-scrollbar when click in select input and
                        // take 100% width in responsive also
                        // theme: 'bootstrap4',
                        dropdownAutoWidth: true,
                        width: '100%',
                        dropdownParent: $this.parent(),
                        // dropdownCssClass: "bigdrop"
                    })
                })
                // CLEAR SELECT2 VALUE IN REFRESH
                // $('.select2').val(null).trigger('change.select2')

                // TOMBOL TAMBAH DATA
                $('#tombol-tambah').click(function () {
                    $('#button-simpan').val("create-post"); //valuenya menjadi create-post
                    $('#user_id').val(''); //valuenya menjadi kosong
                    $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
                    $('#modal-judul').html("Add New User"); //valuenya tambah pegawai baru
                    $('#tambah-edit-modal').modal('show'); //modal tampil
                    $("#role_id").trigger('change');
                });

                // //TOMBOL EDIT DATA
                $('body').on('click', '.edit-post', function () {
                    var data_id = $(this).data('id');
                    $.get('users/' + data_id + '/edit', function (data) {
                        $('#modal-judul').html("Edit User");
                        $('#tombol-simpan').val("edit-post");
                        $('#tambah-edit-modal').modal('show');

                        //set value masing-masing id berdasarkan data yg diperoleh dari ajax get request diatas
                        $('#user_id').val(data.id);
                        $('#role_id').val(data.roles[0].id);
                        $('#name').val(data.name);
                        $('#email').val(data.email);

                        $("#role_id").trigger('change');
                    })
                });

                // //SIMPAN & UPDATE DATA DAN VALIDASI (SISI CLIENT)
                if ($("#form-tambah-edit").length > 0) {
                    $("#form-tambah-edit").validate({
                        rules: {
                            'role_id': {
                                required: true
                            },
                            'name': {
                                required: true
                            },
                            'email': {
                                required: true
                            },
                            'password' : {
                                minlength : 6
                            },
                            'password_confirmation' : {
                                minlength : 6,
                                equalTo : '[name="password"]'
                            },
                        },
                        submitHandler: function (form) {
                            var actionType = $('#tombol-simpan').val();
                            $('#tombol-simpan').html('Sending..');

                            $.ajax({
                                data: $('#form-tambah-edit').serialize(),
                                url: "{{ route('users.store') }}",
                                type: "POST",
                                dataType: 'json',
                                success: function (data) {
                                    $('#form-tambah-edit').trigger("reset");
                                    $('#tambah-edit-modal').modal('hide');
                                    $('#tombol-simpan').html('Simpan');
                                    var oTable = $('#user_table').dataTable(); //inialisasi datatable
                                    oTable.fnDraw(false); //reset datatable
                                    iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                        title: 'Data Berhasil Disimpan',
                                        message: '{{ Session('
                                        success')}}',
                                        position: 'bottomRight'
                                    });
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                    $('#tombol-simpan').html('Simpan');
                                }
                            });
                        }
                    })
                }

                // DISPLAY DATATABLE
                let t = $('#user_table').DataTable({
                    processing: true,
                    serverSide: true, //aktifkan server-side
                    scrollX: true,
                    dom: `<'row'<'col-sm-6 mt-1'f><'col-sm-6 mt-1 pt-1'l>> <'row'<'col-sm-12'tr>> <'row'<'col-sm-6 float-left'i><'col-sm-6 mt-2 float-right'p>>`,
                    ajax: {
                        url: "{{ route('users.index') }}",
                        type: 'GET',
                    },
                    columnDefs: [
                        { targets: 0, className: "text-center", searchable: false, orderable: false, defaultContent: '' },
                        {
                            // User Is Active
                            targets: 4,
                            render: function (data, type, full, meta) {
                                let isActive = ''
                                if (data == 1) isActive = 'Active'
                                else isActive = 'Unactive'
                                return isActive
                            }
                        },
                    ],
                    columns: [
                        { data: null, name: null },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'role', name: 'role' },
                        { data: 'is_active', name: 'is_active' },
                        { data: 'updated_by', name: 'updated_by' },
                        { data: 'action', name: 'action', searchable: false },
                    ],
                    initComplete: function () {

                        $('#filter-role').on('change', function () {
                            var val = $(this).val();
                            t.columns(2).search( val ).draw();
                        });

                        $('#filter-status').on('change', function () {
                            var val = $(this).val();
                            t.columns(4).search( val ).draw();
                        });

                    },
                    rowCallback: function ( row, data ) {
                        $('input.toggle-class', row).prop( 'checked', data.is_active == '1').bootstrapToggle({size: 'sm', width:"80"});
                    }
                })

                $('#user_table').on( 'change', 'input.toggle-class', function () {
                    let isActive = $(this).prop('checked') == true ? '1' : '0'
                    let userId = $(this).data('id')

                    $.ajax({
                        url: '{{ route("users.change-status") }}',
                        type: 'GET',
                        data: {is_active:isActive, user_id:userId},
                        success: function(data) {
                            var oTable = $('#user_table').dataTable(); //inialisasi datatable
                            oTable.fnDraw(false); //reset datatable
                            iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Status berhasil diubah',
                                message: '{{ Session('
                                    success')}}',
                                position: 'bottomRight'
                            });
                        }
                    })
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
        User Lists
    @endslot

    @slot('breadcrumbs')
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item active">User</li>
        </ol>
    @endslot

    @php $role = auth()->user()->roles->pluck('name')[0]; @endphp

    <div class="card px-5 py-4">
        <!-- Filtering starts-->
        <div class="row">
            <div class="col-12">
                <h4 class="card-title">Search & Filter</h4>
            </div>
            <div class="col-md-4 col-12">
                <div class="mb-1">
                    <label class="form-label" for="filter-role">Role</label>
                    <select id="filter-role" class="select2 form-select">
                        <option value="" disabled selected hidden></option>
                        <option value="">All</option>
                        @switch($role)
                            @case('Super Admin')
                                @foreach (App\Models\Role::all() as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                                @break
                            @case('Admin')
                                @foreach (App\Models\Role::whereNotIn('name', ['Super Admin'])->get() as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                                @break
                        @endswitch
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="mb-1">
                    <label class="form-label" for="filter-status">Status</label>
                    <select id="filter-status" class="select2 form-select">
                        <option value="" disabled selected hidden></option>
                        <option value="">All</option>
                        @foreach (App\Models\User::STATUS as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- Filtering ends-->

        <div class="row mt-1">
            <div class="col-sm-6">
                <div class="float-left">
                    {{-- <span class="font-weight-bold">User</span> --}}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-right">
                    <div>
                        <a href="javascript:void(0)" class="btn btn-info" id="tombol-tambah"><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        {{-- Awal Table --}}
        <table class="table table-striped table-bordered table-sm nowrap" style="width:100%" id="user_table">
            <thead>
                <tr>
                    <th style="width: 2em">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th style="width: 15em">Last Update By</th>
                    <th style="width: 15em">Actions</th>
                </tr>
            </thead>
        </table>
        {{-- Akhir table --}}
    </div>

    <!-- MULAI MODAL FORM TAMBAH/EDIT-->
    <div class="modal fade" id="tambah-edit-modal" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-12">

                                <input type="hidden" name="user_id" id="user_id">

                                <div class="form-group px-3 select-role">
                                    <label for="role_id">Role</label>
                                    <select class="form-control select2 role-select" id="role_id" name="role_id" required>
                                        <option value="" disabled selected hidden></option>
                                        @foreach (App\Models\Role::whereNotIn('name', ['Super Admin'])->get() as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-sm-12 control-label">Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name"  value="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-12 control-label">Email</label>
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control" id="email" name="email" value="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-12 control-label">Password</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control form-control-merge" id="password" name="password" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="col-sm-12 control-label">Confirm Password</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control form-control-merge" id="password_confirmation" name="password_confirmation" />
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12 mx-3 my-3">
                                <button type="submit" class="btn btn-primary" id="tombol-simpan" value="create" style="width: 30.25em;">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- AKHIR MODAL -->
</x-app-layout>
