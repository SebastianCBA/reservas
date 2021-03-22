@extends('layouts.app')

@section('title', 'Crear Reserva')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <link href="{{ asset('js/chosen/chosen.css') }}" rel="stylesheet">
    <script src="{{ asset('js/chosen/chosen.jquery.js') }}"></script>
@endsection

@section('content')

<div class="container">
{!! Form::open(['route' => 'reservas.guardar', 'method' => 'POST']) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">
                <strong>Seleccione un Usuario</strong>
                {!! Form::select('usuarios[]', $usuarios, null, ['class'=>'form-control select-usuarios', 'id' => 'usuarios']) !!}
            </div> 


            <div class="form-group">
                <strong>Seleccione una fecha</strong>
                {!! Form::text('fecha', null, ['class' => 'date form-control', 
                                               'required', 'autocomplete' => 'off',
                                               'ng-change' => 'busco_disponibilidad()',
                                               'ng-model' => 'fecha'] ) !!}
            </div>
            
            <div class="form-group" ng-if="can">        
                <table>
                    <tbody>
                        <tr ng-repeat="i in butacas track by $index" >
                            <td ng-repeat="y in i track by $index">
                                <a href="javascript:;" ng-click="ocupar_butaca($parent.$index, $index)"><img ng-src="img/disponible.gif" ng-if="y == 0"></a>
                                <img ng-src="img/no_disponible.gif" ng-if="y == 1">
                                <a href="javascript:;" ng-click="desocupar_butaca($parent.$index, $index)"><img ng-src="img/ocupando.gif" ng-if="y == 2"></a>
                            </td>
                        </tr>    
                    </tbody>
                    
                </table>
            </div>             

            <div class="form-group" ng-if="!can">        
                <table>
                    <tbody>
                        <tr ng-repeat="i in butacas track by $index" >
                            <td ng-repeat="y in i track by $index">
                                
                                <img ng-src="img/reset.gif">
                                
                            </td>
                        </tr>    
                    </tbody>
                    
                </table>
            </div> 
                {!! Form::button('Agregar', ['class' => 'btn btn-primary',
                                             'ng-click' => 'crear_reserva()',
                                             'ng-disabled' => 'disabled']) !!}
        
    </div>


{!! Form::close() !!}
</div>

@endsection

@section('js')
    <script type="text/javascript">
        $('.date').datepicker({  
           format: 'dd/mm/yyyy',
           autoclose: true
         }).datepicker("setDate", new Date());  
        $(".select-usuarios").chosen({
            disable_search_threshold: 1,
            no_results_text: "Oops, no encontré ningun usuario",
            placeholder_text_multiple: "Seleccione un usuario"});
    </script> 


    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-resource.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-mocks.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-sanitize.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-route.min.js"></script>
    
    <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-animate.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-aria.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-messages.min.js'></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection