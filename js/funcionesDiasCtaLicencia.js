$(function(){
	var FuncionesDiasCtaLicencia = {};

	(function (app){
		app.init = function(){
			funcionesUsuarioPermisos(app);
			app.activarPermisos();
			//Se comparten todas las funciones de Empleado
			funcionesVacaciones(app);
			//Se carga la tabla de los pedidos de vacaciones
			app.cargarDiasCtaLicencia();
			app.limpiarModal();
			//Se inician los oyentes para los pedidos de vacaciones
			app.oyentes("DiasCtaLicencia");
			
		};

		app.init();

	}) (FuncionesDiasCtaLicencia);
});