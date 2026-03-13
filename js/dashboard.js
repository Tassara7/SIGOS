document.addEventListener('DOMContentLoaded', function () {

    var canvas = document.getElementById('graficoOrdens');

    if (!canvas) return;

    new Chart(canvas, {
        type: 'pie',
        data: {
            labels: ['Abertas', 'Em andamento', 'Concluídas'],
            datasets: [{
                data: [
                    parseInt(canvas.dataset.abertas),
                    parseInt(canvas.dataset.andamento),
                    parseInt(canvas.dataset.concluidas)
                ],
                backgroundColor: ['#dc3545', '#ffc107', '#198754']
            }]
        }
    });

});
