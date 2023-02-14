@extends("admin.layout.overall")

@section('title','Charts')

@section('content')
{{-- content --}}
    <div class="content">
        <div class="justify-content-between mt-5" style="display: flex;">
            <div class="card card-body mt-2 " style="width:50%">
                <div class="d-flex justify-content-center">
                    <h4>Sale Chart</h4>
                </div>
                <div>
                    <canvas id="myChart" width="100%" height=""></canvas>
                </div>
            </div>
            &nbsp;&nbsp;

            <div class="card card-body mt-2" style="width:50%">
                <div class="d-flex justify-content-center">
                    <h4>View Count Graph</h4>
                </div>
                <div>
                    <canvas id="myChart1" width="100%"></canvas>
                </div>
            </div>
        </div>
    </div>

{{-- end content --}}
@endsection

@section('script')
    <script>
        const ctx = document.getElementById('myChart');
        const ctx1 = document.getElementById('myChart1');

        var total = JSON.parse('{!! json_encode($sale) !!}');
        var total1 = JSON.parse('{!! json_encode($sale1) !!}');

        var view = JSON.parse('{!! json_encode($view) !!}');
        var view1 = JSON.parse('{!! json_encode($view1) !!}');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'This Year',
                    data: total.map(row=>({
                        x:row.month_name,
                        y:row.total
                    })),
                    borderWidth: 1
                }, {
                    label: 'Last Year',
                    data: total1.map(row => ({
                      x: row.month_name,
                      y: row.total,
                    })),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins :{
                    tooltip : {
                        backgroundColor	: 'rgba(0, 0, 0, 0.5)',
                    }
                }
            }
        });

        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'This Year',
                    data: view.map(v=>({
                        x:v.month_name,
                        y:v.count
                    })),
                    borderWidth: 1,
                    fill: true
                }, {
                    label: 'Last Year',
                    data: view1.map(v=>({
                        x:v.month_name,
                        y:v.count
                    })),
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    // animation: false,
                    y: {
                        beginAtZero: true
                    },
                }
            }
        });
    </script>
@endsection
