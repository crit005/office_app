<div class="bg-white p-4 mx-4 mt-4">
    <div>
        <canvas id="chart"></canvas>
    </div>
    <script>
        var chart = new Chart(
            document.getElementById('chart'), {
                type: 'bar',
                data: {
                    labels: @json($labels[0]),
                    // labels:["ACC","FIFA","BVIP","MBO","Lucky","HengHeng","DeeDee","Acc Thai","PK/THAI","QQ Thai","OFFICE"],
                    datasets: @json($dataset)
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            }
        );
        // Livewire.on('updateChart', data => {
        //     chart.data = data;
        //     chart.update();
        // });
    </script>
</div>

@push('js')
    <script>
        Livewire.on('updateChart', data => {
            chart.data = data;
            chart.update();
        });
    </script>
@endpush
