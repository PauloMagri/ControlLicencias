$(function(){
	var FuncionesLicenciaVacaciones = {};

	(function (app){
		app.init = function(){
			funcionesUsuarioPermisos(app);
			app.activarPermisos();
			//Se comparten todas las funciones de Empleado
			funcionesVacaciones(app);
			//Se carga la tabla de los pedidos de vacaciones
			app.cargarLicenciaVacaciones();
			//Se inician los oyentes para los pedidos de vacaciones
			app.oyentes("LicenciaVacaciones");
			
		};

		app.init();

	}) (FuncionesLicenciaVacaciones);
});