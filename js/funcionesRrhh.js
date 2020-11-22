$(function(){
	var funcionesRrhh = {};
	(function (app){
		app.init = function(){
			funcionesUsuarioPermisos(app);
			app.activarPermisos();
		};

		app.init();

	}) (funcionesRrhh);
});