@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

@section('content')
    <div class="container  py-12">
        <div class="flex flex-wrap justify-center gap-10">




            <div class="w-full md:w-1/3 lg:w-1/4 bg-white shadow-lg rounded-lg p-2">
                <a href="{{ route('mission.index') }}">

                    <h2 class="text-xl font-semibold mb-4 text-center cursor-pointer">
                        Görev Durumu
                    </h2>
                    <canvas id="taskStatusChart" height="200"> </canvas>
            </div>
            </a>




            <div class="w-full md:w-1/3 lg:w-1/4 bg-white shadow-lg rounded-lg p-4">
                <a href="{{ route('admin.offdays.index') }}">

                    <h2 class="text-xl font-semibold mb-4 text-center">Aylık İzinler</h2>
                    <div class="relative">
                        <canvas id="offdayChart" width="75" height="75" style="width: 75px; height: 75px;"></canvas>
                    </div>
            </div>
        </div>
        </a>

    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        // Task Status Chart
        $(document).ready(function() {
            $.ajax({
                url: '/tasks/status-counts',
                method: 'GET',
                success: function(data) {
                    var statuses = ['Atandı', 'Devam Ediyor', 'Revize', 'Onay Bekliyor', 'Onaylandı'];
                    var counts = statuses.map(status => data[status] || 0);
                    var totalCount = counts.reduce((a, b) => a + b, 0);

                    var ctx = document.getElementById('taskStatusChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: statuses,
                            datasets: [{
                                label: 'Task Status',
                                data: counts,
                                backgroundColor: [
                                    'rgba(125, 211, 252, 0.5)', // Atandı - bg-sky-200
                                    'rgba(255, 165, 0, 0.5)', // Başladı - bg-orange-200
                                    'rgba(200, 230, 201, 0.5)', // Devam Ediyor - #8bc34a (100 tone)
                                    'rgba(255, 165, 0, 0.5)', // Test Ediliyor - bg-orange-200
                                    'rgba(125, 211, 252, 0.5)', // Tamamlandı - bg-sky-200
                                ],
                                borderColor: [
                                    'rgba(14, 165, 233, 1)', // Atandı - bg-sky-500
                                    'rgba(255, 165, 0, 1)', // Başladı - bg-orange-500
                                    'rgba(139, 195, 74, 1)', // Devam Ediyor - #8bc34a
                                    'rgba(255, 165, 0, 1)', // Test Ediliyor - bg-orange-500
                                    'rgba(14, 165, 233, 1)', // Tamamlandı - bg-sky-500
                                ],
                                borderWidth: 3,
                                borderRadius: 8,
                                barThickness: 50
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            var percentage = (tooltipItem.raw / totalCount *
                                                100).toFixed(2);
                                            return `${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                                        }
                                    }
                                },
                                datalabels: {
                                    display: function(context) {
                                        return context.dataset.data[context.dataIndex] !==
                                            0;
                                    },
                                    formatter: (value, ctx) => {
                                        let sum = ctx.dataset.data.reduce((a, b) => a + b,
                                            0);
                                        let percentage = (value / sum * 100).toFixed(2);
                                        return percentage + '%';
                                    },
                                    color: '#fff',
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        maxRotation: 0,
                                        minRotation: 0,
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    ticks: {
                                        beginAtZero: true,
                                        precision: 0
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        },
                        plugins: []
                    });
                },
                error: function(error) {
                    console.log('Error fetching status counts:', error);
                }
            });
        });

        // Offday Chart
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/offday/monthly-data')
                .then(response => response.json())
                .then(data => {
                    const months = data.map(item => `${item.month}. ay`);
                    const counts = data.map(item => item.count);

                    const ctx = document.getElementById('offdayChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: months,
                            datasets: [{
                                label: 'Offdays Count',
                                data: counts,
                                backgroundColor: 'rgba(200, 230, 201, 0.5)',
                                borderColor: '#8bc34a',
                                borderWidth: 3
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                        }
                                    }
                                }
                            },
                            cutout: '50%',
                        }
                    });
                });
        });
    </script>
@endsection
