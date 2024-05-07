<x-app-layout>
    @slot('styles')
        <style>
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

                // PROVENSI
                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
                .then(response => response.json())
                .then(provinces => {

                    let provincyOptions = '';
                    let provincyHtml = '';

                    $.each(provinces, function (i, provincy) {
                        provincyOptions += `
                            <option value="${provincy.id}">${provincy.name}</option>
                        `
                    })

                    provincyHtml = `
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="filter-provinsi">Provinsi</label>
                                    <select id="filter-provinsi" class="select2 form-select">
                                        <option value="" disabled selected hidden></option>
                                        ${provincyOptions}
                                    </select>
                                </div>

                                <div div id="regency-select-html"></div>
                            </div>
                        </div>
                    `
                    
                    $('#provincy-select-html').html(provincyHtml)

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

                });

                // KABUPATEN / KOTA
                $(document).on('change', '#filter-provinsi', function() {
                    $('#regency-select-html').html('')

                    let provincyId = $(this).val()
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provincyId}.json`)
                        .then(response => response.json())
                        .then(regencies => {

                            let regencyOptions = '';
                            let regencyHtml = '';

                            $.each(regencies, function (i, regency) {
                                regencyOptions += `
                                    <option value="${regency.id}">${regency.name}</option>
                                `
                            })

                            regencyHtml = `
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="filter-regency">Kabupaten/Kota</label>
                                            <select id="filter-regency" class="select2 form-select">
                                                <option value="" disabled selected hidden></option>
                                                ${regencyOptions}
                                            </select>
                                        </div>

                                        <div div id="district-select-html"></div>
                                    </div>
                                </div>
                            `
                            
                            $('#regency-select-html').html(regencyHtml)

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

                        });
                });
                
                // KECAMATAN
                $(document).on('change', '#filter-regency', function() {
                    $('#district-select-html').html('')

                    let districtId = $(this).val()
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${districtId}.json`)
                    .then(response => response.json())
                    .then(districts => {

                        let districtOptions = '';
                        let districtHtml = '';

                        $.each(districts, function (i, district) {
                            districtOptions += `
                                <option value="${district.id}">${district.name}</option>
                            `
                        })

                        districtHtml = `
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="filter-district">Kecamatan</label>
                                        <select id="filter-district" class="select2 form-select">
                                            <option value="" disabled selected hidden></option>
                                            ${districtOptions}
                                        </select>
                                    </div>

                                    <div div id="village-select-html"></div>
                                </div>
                            </div>
                        `
                        
                        $('#district-select-html').html(districtHtml)
                        
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

                    });

                })

                // KELURAHAN
                $(document).on('change', '#filter-district', function() {
                $('#village-select-html').html('')

                let villageId = $(this).val()
                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${villageId}.json`)
                    .then(response => response.json())
                    .then(villages => {

                        let villageOptions = '';
                        let villageHtml = '';

                        $.each(villages, function (i, village) {
                            villageOptions += `
                                <option value="${village.id}">${village.name}</option>
                            `
                        })

                        villageHtml = `
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="filter-village">Kelurahan</label>
                                        <select id="filter-village" class="select2 form-select">
                                            <option value="" disabled selected hidden></option>
                                            ${villageOptions}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        `
                        
                        $('#village-select-html').html(villageHtml)

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

                    });

                })

            })
        </script>
    @endslot

    @slot('contentHeader')
        Dropdown
    @endslot

    @slot('breadcrumbs')
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Dropdown</li>
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

         <!-- Filtering starts-->
         <div class="row mb-3">
            <div class="col-12">
                <h4 class="card-title font-weight-bolder">Data Wilayah Indonesia</h4>
            </div>
        </div>

        <div id="provincy-select-html"></div>
        <!-- Filtering ends-->
       
    </div>
</x-app-layout>