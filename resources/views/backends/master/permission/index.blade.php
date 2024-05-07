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

                //TOMBOL TAMBAH DATA
                $('#tombol-tambah').click(function () {
                    $('#button-simpan').val("create-post"); //valuenya menjadi create-post
                    $('#permission_id').val(''); //valuenya menjadi kosong
                    $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
                    $('#modal-judul').html("Add New Permission"); //valuenya tambah pegawai baru
                    $('#tambah-edit-modal').modal('show'); //modal tampil
                });

                //TOMBOL EDIT DATA
                $('body').on('click', '.edit-post', function () {
                    var data_id = $(this).data('id');
                    $.get('permissions/' + data_id + '/edit', function (data) {
                        $('#modal-judul').html("Edit Permission");
                        $('#tombol-simpan').val("edit-post");
                        $('#tambah-edit-modal').modal('show');

                        //set value masing-masing id berdasarkan data yg diperoleh dari ajax get request diatas
                        $('#permission_id').val(data.id);
                        $('#name').val(data.name);
                        $('#description').val(data.description);
                    })
                });

                //SIMPAN & UPDATE DATA DAN VALIDASI (SISI CLIENT)
                if ($("#form-tambah-edit").length > 0) {
                    $("#form-tambah-edit").validate({
                        rules: {
                            'name': {
                                required: true
                            },
                            'description': {
                                required: true
                            }
                        },
                        submitHandler: function (form) {
                            var actionType = $('#tombol-simpan').val();
                            $('#tombol-simpan').html('Sending..');

                            $.ajax({
                                data: $('#form-tambah-edit').serialize(),
                                url: "{{ route('permissions.store') }}",
                                type: "POST",
                                dataType: 'json',
                                success: function (data) {
                                    $('#form-tambah-edit').trigger("reset");
                                    $('#tambah-edit-modal').modal('hide');
                                    $('#tombol-simpan').html('Simpan');
                                    var oTable = $('#permission_table').dataTable(); //inialisasi datatable
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

                // DELETE DATA
                $('body').on('click', '.delete', function () {
                    // Sweet Alert here
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '<i class="fas fa-save"></i> Yes, delete it!',
                        cancelButtonText: '<i class="fas fa-times"></i> Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let permission_id = $(this).data('id') //get id
                            $.ajax({
                                url: "permissions/" + permission_id, //eksekusi ajax ke url ini
                                type: 'POST',
                                data: {
                                    _method: 'DELETE',
                                },
                                success: function (data) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    setTimeout(function () {
                                        var oTable = $('#permission_table').dataTable();
                                        oTable.fnDraw(false); //reset datatable
                                    });
                                }
                            })
                        }
                    })
                })

                // DISPLAY DATATABLE
                var t = $('#permission_table').DataTable({
                    processing: true,
                    serverSide: true, //aktifkan server-side
                    scrollX: true,
                    dom: `<'row'<'col-sm-6 mt-1 float-left'f><'col-sm-6 mt-1 pt-1 float-right'l>> <'row'<'col-sm-12'tr>> <'row'<'col-sm-6 float-left'i><'col-sm-6 mt-2 float-right'p>>`,
                    ajax: {
                        url: "{{ route('permissions.index') }}",
                        type: 'GET'
                    },
                    columnDefs: [
                        { targets: 0, className: "text-center", searchable: false, orderable: false, defaultContent: '' },
                    ],
                    columns: [
                        { data: null, name: null },
                        { data: 'name', name: 'name' },
                        { data: 'description', name: 'description' },
                        { data: 'updated_at', name: 'updated_at' },
                        { data: 'action', name: 'action', searchable: false },
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
        Permission Lists
    @endslot

    @slot('breadcrumbs')
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item active">Permission</li>
        </ol>
    @endslot

    <div class="card px-5 py-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="float-right">
                    <div>
                        <a href="javascript:void(0)" class="btn btn-info" id="tombol-tambah"><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        {{-- Awal Table --}}
        <table class="table table-striped table-bordered table-sm nowrap" style="width:100%" id="permission_table">
            <thead>
                <tr>
                    <th style="width: 3em">#</th>
                    <th>Permission Name</th>
                    <th>Description</th>
                    <th style="width: 15em">Last Update At</th>
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

                                <input type="hidden" name="permission_id" id="permission_id">

                                <div class="form-group">
                                    <label for="name" class="col-sm-12 control-label">Permission Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="" oninput="this.value = this.value.replace(/\s/g, '');" >
                                    </div>
                                </div>

                                <div class="form-group px-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
