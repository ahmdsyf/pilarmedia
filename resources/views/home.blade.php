<x-app-layout title="Home">

    @slot('contentHeader')
        Dashboard
    @endslot

    @slot('breadcrumbs')
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    @endslot

    @slot('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function() {

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

                $.ajax({
                    url: '{{ route("home.get-sales-report-summaries") }}',
                    type: 'GET',
                    // data: { sales_person: salesPerson, month: month, year: year },
                    data: { sales_person: 4 },
                    contentType: "application/json",
                    dataType: 'json',
                    success: function (data) {

                        console.log(data)

                        $('#sales-report-summary-chart').replaceWith($(`<canvas id="sales-report-summary-chart" class="chartjs" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 655px;" width="655" height="200"></canvas>`));
                            let ctx = document.getElementById("sales-report-summary-chart")
                            var barChartExample = new Chart(ctx, {
                            type: 'line',
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                datasetFill: false,
                                tooltips: {
                                },
                            },
                            data: {
                                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                datasets: [
                                    {
                                        label: 'Sales Amount',
                                        data: [21,40,54, 20,45],
                                        // barThickness: 30,
                                        backgroundColor: 'rgba(255,0,0, 0.2)',
                                        borderColor: 'rgba(255,0,0, 1)',
                                        borderWidth: 1,
                                        tension: 0.4,
                                        fill: true
                                    },
                                ]
                            }
                        });
                    }
                })
            })
        </script>
    @endslot

    <div class="container">
        <div id="chart">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                            <div class="header-left">
                                <h4 class="card-title">
                                    <div class="d-flex align-items-center align-content-between flex-wrap">
                                        <span>Sales Summary Report</span>
                                        &ensp;|&ensp;
                                        <select id="project-report-summary-year-select" class="select2 form-select" style="width: 3em">
                                            <option value="" disabled selected hidden></option>
                                            @foreach (App\Models\SalesPersons::all() as $salesPerson)
                                                <option value="2023">{{ $salesPerson->SalesPersonName }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="sales-report-summary-chart" class="chartjs" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 655px;" width="655" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
</x-app-layout>