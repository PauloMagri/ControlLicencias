$(function()
{
	var FuncionesSesion = {};

	(function (app) {
		app.init = function()
		{
			app.comprobarSesion();
		};

		//Se comprueba que haya sesion activa
		app.comprobarSesion = function()
		{
			var url = "../controlador/ruteador/Ruteador.php";
			$.ajax({
				url : url,
				dataType: 'json',
				success : function(data)
				{
					if(data == false)
					{
						window.location = "../index.html";
					}
				},
				error : function()
				{
					alert('Hubo un error al comprobar la sesion');
					window.location = "index.html";
				}
			});
		};

		app.init();

	})(FuncionesSesion);
});