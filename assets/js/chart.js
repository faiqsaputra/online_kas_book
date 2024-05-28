// file: assets/js/chart.js

// Fungsi untuk membuat grafik kas masuk per bulan
function renderKasMasukChart(dataBulan, dataKasMasuk) {
    var ctxKasMasuk = document.getElementById('kasMasukChart').getContext('2d');
    new Chart(ctxKasMasuk, {
        type: 'bar',
        data: {
            labels: dataBulan,
            datasets: [{
                label: 'Kas Masuk',
                data: dataKasMasuk,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Fungsi untuk membuat grafik kas keluar per bulan
function renderKasKeluarChart(dataBulan, dataKasKeluar) {
    var ctxKasKeluar = document.getElementById('kasKeluarChart').getContext('2d');
    new Chart(ctxKasKeluar, {
        type: 'line',
        data: {
            labels: dataBulan,
            datasets: [{
                label: 'Kas Keluar',
                data: dataKasKeluar,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Mendapatkan data dari atribut data-* di elemen canvas
document.addEventListener('DOMContentLoaded', function () {
    var kasMasukChartElement = document.getElementById('kasMasukChart');
    var kasKeluarChartElement = document.getElementById('kasKeluarChart');

    var dataBulan = JSON.parse(kasMasukChartElement.getAttribute('data-bulan'));
    var dataKasMasuk = JSON.parse(kasMasukChartElement.getAttribute('data-kas-masuk'));
    var dataKasKeluar = JSON.parse(kasKeluarChartElement.getAttribute('data-kas-keluar'));

    renderKasMasukChart(dataBulan, dataKasMasuk);
    renderKasKeluarChart(dataBulan, dataKasKeluar);
});
