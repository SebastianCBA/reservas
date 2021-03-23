var app = angular.module("app", ["ngResource"], function($interpolateProvider) 
    {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    });



app.constant('BASE', 'http://localhost:81/reservas/public_html/');

app.config(['$locationProvider', function($locationProvider){

    $locationProvider.html5Mode({
          enabled: true,
          requireBase: false
          }).hashPrefix('');
}]);



app.controller("appController", ['$scope', '$sce', 'BASE', '$window', '$rootScope',  '$http','$q','$location','$filter',  function ($scope, $sce, BASE, $window, $rootScope, $http, $q, $location, $filter) {
  
  $rootScope.base = BASE;
  $scope.fecha = fecha;
  
  $scope.butacas = [];
  $scope.filas = 5;
  $scope.columnas = 10;
  $scope.can = 0;
  $scope.disabled = true;
  $scope.reserve = 0;

  $scope.inicializar_butacas = function() {
    $scope.butacas = [];    
    for (var i = 0; i < $scope.filas; i++) {
            var row = [];
            for (j = 0; j < $scope.columnas; j++) {
                row.push(0);
            }
            $scope.butacas.push(row);
        }  
    };

  $scope.ocupar_butaca = function(f, c) {
    $scope.reserve += 1;
    $scope.butacas[f][c] = 2;
    if($scope.reserve > 0)
      {
      $scope.disabled = false;      
      }    
    };

  $scope.butaca_no_disponible = function(f, c) {
    $scope.butacas[f][c] = 1;
    };

  $scope.desocupar_butaca = function(f, c) {
    $scope.reserve -= 1;
    $scope.butacas[f][c] = 0;
    if($scope.reserve == 0)
      {
      $scope.disabled = true;      
      }        
    };  

  $scope.busco_disponibilidad = function() {
    console.log('consulto disponibilidad');
    $scope.inicializar_butacas();
    $scope.can = 0;
    $scope.disabled = true;
    var promise
    promise = $http.get($scope.base+'consultardisponibilidad/'+$scope.fecha);
    promise.then(function(data) {
      
      for (var i = 0; i < data.data.length; i++) {
              row = data.data[i];
              for (j = 0; j < row.length; j++) {
                if(data.data[i][j] == 1)
                  {
                    $scope.butaca_no_disponible(i, j);
                  }
              }
          }  
    });
    $scope.can = 1;
  }

  $scope.busco_reserva = function(id) {
    console.log('busco reserva');
    $scope.inicializar_butacas();
    $scope.can = 0;
    $scope.disabled = true;
    var promise
    promise = $http.get($scope.base+'buscoreserva/'+id);
    promise.then(function(data) {
      
      for (var i = 0; i < data.data.length; i++) {
              row = data.data[i];
              for (j = 0; j < row.length; j++) {
                if(data.data[i][j] == 1)
                  {
                    $scope.butaca_no_disponible(i, j);
                  }
                if(data.data[i][j] == 2)
                  {
                    $scope.ocupar_butaca(i, j);
                  }                  
              }
          }  
    });
    $scope.can = 1;
  }

  $scope.crear_reserva = function(){
    console.log('creo reserva');
    var formData = new FormData();
    var usuario = $("#usuarios").val();
    $http({
          method: 'POST', 
          url: $scope.base+'guardar-reserva', 
          data: {
              usuario_id: usuario,
              cantidad: $scope.reserve,
              fecha: $scope.fecha,
              butacas: $scope.butacas
          } }).success(function(data, status, headers, config) {
              $window.location.href = $scope.base+'reservas';
          }).
          error(function(data, status, headers, config) {
              console.log(data);
          });    
  }

  $scope.actualizar_reserva = function(){
    console.log('actualizo reserva');
    var formData = new FormData();
    var usuario = $("#usuarios").val();
    
    $http({
          method: 'POST', 
          url: $scope.base+'actualizar-reserva/'+reserva_id, 
          data: {
              usuario_id: usuario,
              cantidad: $scope.reserve,
              fecha: $scope.fecha,
              butacas: $scope.butacas
          } }).success(function(data, status, headers, config) {
            $window.location.href = $scope.base+'reservas';
          }).
          error(function(data, status, headers, config) {
              console.log(data);
          });    
  }
  
  switch(seccion_id) {
              case 1:
                  $scope.inicializar_butacas();
                  break;
              case 2:
                  $scope.inicializar_butacas();
                  $scope.busco_reserva(reserva_id);
                  break;
              default:

          }

  }]);

