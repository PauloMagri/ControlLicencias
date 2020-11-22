$(function(){
	var FuncionesLegajo = {};

	(function (app){
		app.init = function(){
			funcionesUsuarioPermisos(app);
			app.activarPermisos();
			//Se comparten todas las funciones de Empleado
			funcionesEmpleado(app);
			//Se carga la tabla de los empleados
			app.cargarEmpleados();
			app.listarSecciones();
			app.listarDelegaciones();
			app.limpiarModal();
			//Se inician los oyentes para los legajos
			app.oyentes();
			
		};

		app.init();

	}) (FuncionesLegajo);
});