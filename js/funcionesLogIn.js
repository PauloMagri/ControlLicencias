$(function ()
	{
		var FuncionesLogIn = {};

		(function(app)
			{
				app.init = function()
				{
					app.bindings();
				};

				app.bindings = function(){
					//Variable para redireccionar a la pagina elegida
					var pagina = null;

					//Oyentes para saber a que seccion dirigirse
					$("#btnrrhh").on("click", function()
						{
							pagina = "rrhh";
						});
					$("#btnturismo").on("click", function()
						{
							pagina = "turismo";
						});
					$("#btnsubsidios").on("click", function()
						{
							pagina = "subsidios";
						});
					$("#btnusuarios").on("click", function()
						{
							pagina = "usuarios";
						});
					//Al enviar el formulario, se encriptan el usuario y la clave
					$("#enviar").on("click", function(event)
						{
							var datos = 'u=' + btoa(btoa($("#txtUsuario").val())) + '&c=' + btoa(btoa($("#txtClave").val()));
							//Se envian al RuteadorSesion
							$.ajax({
								type : 'POST',
								url : './controlador/ruteador/RuteadorSesion.php',
								data : datos
							})
								//Se obtuvo una respuesta del servidor
								.done(function(data)
								{
									//Si se ingreso con exito, se redirecciona a la seccion correspondiente
		                            if (data.includes(pagina) == true) {
		                                window.location = pagina + "/" + pagina + ".html";
		                            } else
		                            	{
		                            	alert("No tiene permiso para acceder a esta seccion");
		                            	}
		                            //La clave no era correcta
		                            if (data == 1) {
		                                alert("La clave ingresada es incorrecta");
		                            }
		                            //El usuario no era correcto
		                            if (data == 2) {
		                                alert("El usuario ingresado es incorrecto");
		                            }
								})

								//No se obtuvo una resapuesta del servidor
								.fail(function()
								{
									alert("Hubo un error en la conexion");
								});
							//Se vacian los campos del modal LogIn
							$("#ModalLogIn").modal('hide');
							$("#txtUsuario").val('');
							$("#txtClave").val('');
							return false;
						});
					
				};

				app.init();

			})(FuncionesLogIn);
	});