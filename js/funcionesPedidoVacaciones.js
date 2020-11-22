$(function(){
	var FuncionesPedidoVacaciones = {};

	(function (app){
		app.init = function(){
			funcionesUsuarioPermisos(app);
			app.activarPermisos();
			//Se comparten todas las funciones de Empleado
			funcionesVacaciones(app);
			//Se carga la tabla de los pedidos de vacaciones
			app.cargarPedidosVacaciones();
			app.limpiarModal();
			//Se inician los oyentes para los pedidos de vacaciones
			app.oyentes("PedidoVacaciones");
			
		};

		app.init();

	}) (FuncionesPedidoVacaciones);
});