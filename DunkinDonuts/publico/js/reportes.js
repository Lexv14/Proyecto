document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('graficoVentas').getContext('2d');
    let miGrafico;

    // La función ahora acepta los tres conjuntos de datos
    function generarGrafico(labels, datosVentas, datosCantidad) {
        if (miGrafico) {
            miGrafico.destroy();
        }
        
        miGrafico = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                // AHORA TENEMOS DOS DATASETS, UNO PARA CADA BARRA
                datasets: [
                    {
                        label: 'Total de Ventas (S/)',
                        data: datosVentas,
                        backgroundColor: 'rgba(232, 67, 0, 0.6)', // Naranja Dunkin'
                        borderColor: 'rgba(232, 67, 0, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Cantidad Vendida (Unidades)',
                        data: datosCantidad,
                        backgroundColor: 'rgba(109, 76, 65, 0.6)', // Marrón del panel
                        borderColor: 'rgba(109, 76, 65, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Reporte de Ventas y Cantidades por Producto'
                    }
                }
            }
        });
    }

    function cargarDatosGrafico() {
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;
        const productoId = document.getElementById('producto_id').value;

        const url = `index.php?controlador=reporte&accion=obtenerDatosGraficoAjax&fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}&producto_id=${productoId}`;

        fetch(url)
            .then(response => response.json())
            .then(datos => {
                // Pasamos los nuevos datos a la función del gráfico
                generarGrafico(datos.labels, datos.ventas, datos.cantidad);
            })
            .catch(error => console.error('Error al cargar los datos del gráfico:', error));
    }

    document.getElementById('filtrarBtn').addEventListener('click', cargarDatosGrafico);
    cargarDatosGrafico();
});