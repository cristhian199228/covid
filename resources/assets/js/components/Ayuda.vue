<template>
<main class="main">
    <!-- Breadcrumb -->
    
    <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="card-columns cols-2">
              <div class="card">
                <div class="card-header">Pacientes Atendidos
                  <div class="card-header-actions">
                    <a class="card-header-action" href="http://www.chartjs.org" target="_blank">
                      <small class="text-muted">2020</small>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-wrapper">
                    <canvas id="canvas-1"></canvas>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">Pacientes por Estación
                  <div class="card-header-actions">
                    <a class="card-header-action" href="http://www.chartjs.org" target="_blank">
                      <small class="text-muted">2020</small>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-wrapper">
                    <canvas id="canvas-2"></canvas>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">Resultado de Pruebas
                  <div class="card-header-actions">
                    <a class="card-header-action" href="http://www.chartjs.org" target="_blank">
                      <small class="text-muted">2020</small>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-wrapper">
                    <canvas id="canvas-3"></canvas>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">Pacientes por Estación
                  <div class="card-header-actions">
                    <a class="card-header-action" href="http://www.chartjs.org" target="_blank">
                      <small class="text-muted">2020</small>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-wrapper">
                    <canvas id="canvas-4"></canvas>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">Estado de las pruebas
                  <div class="card-header-actions">
                    <a class="card-header-action" href="http://www.chartjs.org" target="_blank">
                      <small class="text-muted">2020</small>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-wrapper">
                    <canvas id="canvas-5"></canvas>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">Pruebas Invalidas por Estación
                  <div class="card-header-actions">
                    <a class="card-header-action" href="http://www.chartjs.org" target="_blank">
                      <small class="text-muted">2020</small>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-wrapper">
                    <canvas id="canvas-6"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

</main>
</template>
<script>
    export default {
        props : ['ruta'],
        data (){
            return {
                varIngreso:null,
                charIngreso:null,
                ingresos:[],
                varTotalIngreso:[],
                varMesIngreso:[], 
                
                varVenta:null,
                charVenta:null,
                ventas:[],
                varTotalVenta:[],
                varMesVenta:[],
            }
        },
        methods : {


          
            getIngresos(){
                let me=this;
                var url=this.ruta + '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ingresos = respuesta.ingresos;
                    //cargamos los datos del chart
                    me.loadIngresos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },


            getVentas(){
                
                let me=this;
                var url=this.ruta + '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ventas = respuesta.ventas;
                    //cargamos los datos del chart
                    me.loadVentas();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },


            loadIngresos(){
//console.log(location.href);
                var random = function random() {
  return Math.round(Math.random() * 100);
}; 
                let me=this;
                let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]; 
                me.ingresos.map(function(x){
                    me.varMesIngreso.push(meses[x.mes-1]);
                    me.varTotalIngreso.push(x.total);
                });
                me.varIngreso=document.getElementById('canvas-1')

                me.lineChart = new Chart(me.varIngreso, {
  type: 'line',
  data: {
    labels: ["23/04", "24/04", "25/04", "26/04", "27/04", "28/04", "29/04"],
    datasets: [{
      label: 'Pacientes por Día',
      backgroundColor: 'rgba(220, 220, 220, 0.2)',
      borderColor: 'rgba(220, 220, 220, 1)',
      pointBackgroundColor: 'rgba(220, 220, 220, 1)',
      pointBorderColor: '#fff',
      data: [random(), random(), random(), random(), random(), random(), random()]
    }]
  },
  options: {
    responsive: true
  }
}); // eslint-disable-next-line no-unused-vars

var barChart = new Chart($('#canvas-2'), {
  type: 'bar',
  data: {
    labels: ["23/04", "24/04", "25/04", "26/04", "27/04", "28/04", "29/04"],
    datasets: [{
      label: 'Pacientes',
      backgroundColor: 'rgba(220, 220, 220, 0.5)',
      borderColor: 'rgba(220, 220, 220, 0.8)',
      highlightFill: 'rgba(220, 220, 220, 0.75)',
      highlightStroke: 'rgba(220, 220, 220, 1)',
      data: [random(), random(), random(), random(), random(), random(), random()]
    }]
  },
  options: {
    responsive: true
  }
}); // eslint-disable-next-line no-unused-vars

var doughnutChart = new Chart($('#canvas-3'), {
  type: 'doughnut',
  data: {
    labels: ['Asintomaticos', 'Sintomaticos'],
    datasets: [{
      data: [random(), random()],
      backgroundColor: ['#FF6384', '#36A2EB'],
      hoverBackgroundColor: ['#FF6384', '#36A2EB']
    }]
  },
  options: {
    responsive: true
  }
}); // eslint-disable-next-line no-unused-vars

var radarChart = new Chart($('#canvas-4'), {
  type: 'radar',
  data: {
    labels: ['CHI 1', 'CHI 2', 'CHI 3', 'CHI 4','CHI 5'],
    datasets: [{      
      label: 'Pacientes',
      backgroundColor: 'rgba(220, 220, 220, 0.2)',
      borderColor: 'rgba(220, 220, 220, 1)',
      pointBackgroundColor: 'rgba(220, 220, 220, 1)',
      pointBorderColor: '#fff',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(220, 220, 220, 1)',
     data: [random(), random(), random(), random(), random()]
    }]
  },
  options: {
    responsive: true
  }
}); // eslint-disable-next-line no-unused-vars

var pieChart = new Chart($('#canvas-5'), {
  type: 'pie',
  data: {
    labels: ['Invalidas', 'Validas'],
    datasets: [{
      data: [random(), random()],
      backgroundColor: ['#FF6384', '#36A2EB'],
      hoverBackgroundColor: ['#FF6384', '#36A2EB']
    }]
  },
  options: {
    responsive: true
  }
}); // eslint-disable-next-line no-unused-vars

var polarAreaChart = new Chart($('#canvas-6'), {
  type: 'polarArea',
  data: {
    labels: ['CHI 1', 'CHI 2', 'CHI 3', 'CHI 4', 'CHI 5'],
    datasets: [{
      data: [random(), random(), random(), random(), random()],
      backgroundColor: ['#FF6384', '#4BC0C0', '#FFCE56', '#E7E9ED', '#36A2EB']
    }]
  },
  options: {
    responsive: true
  }
});
            },
            
            loadVentas(){
                let me=this;
                let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]; 
                me.ventas.map(function(x){
                    me.varMesVenta.push(meses[x.mes-1]);
                    me.varTotalVenta.push(x.total);
                });
                me.varVenta=document.getElementById('ventas');

                me.charVenta = new Chart( me.varVenta, {
  type: 'radar',
  data: {
    labels: ['LINGA', 'SUR', 'HALCON 21', 'CONCENTRADORA','LAYDOWM'],
    datasets: [{
      label: 'My First dataset',
      backgroundColor: 'rgba(220, 220, 220, 0.2)',
      borderColor: 'rgba(220, 220, 220, 1)',
      pointBackgroundColor: 'rgba(220, 220, 220, 1)',
      pointBorderColor: '#fff',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(220, 220, 220, 1)',
      data: [random(), random(), random(), random(), random()]
    }, {
      label: 'My Second dataset',
      backgroundColor: 'rgba(151, 187, 205, 0.2)',
      borderColor: 'rgba(151, 187, 205, 1)',
      pointBackgroundColor: 'rgba(151, 187, 205, 1)',
      pointBorderColor: '#fff',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(151, 187, 205, 1)',
      data: [random(), random(), random(), random(), random()]
    }]
  },
  options: {
    responsive: true
  }
});
            }
        },
        mounted() {
            this.loadIngresos();
            this.loadVentas();
        }
    }
</script>
