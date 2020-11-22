$(function(){
	var fu = {};
	(function (app){
		app.init = function(){
			funcionesUsuarioPermisos(app);
			app.activarPermisos();
			//Se comparten todas las funciones de Usuario
			funcionesUsuarios(app);
			//Se carga la tabla de los usuarios
			app.cargarUsuarios();
			//Se inician los oyentes para el manejo de usuarios
			app.oyentes("Usuario");
			
		};

		app.init();

	}) (fu);
});

function funcionesUsuarios(app){

	//Se carga la tabla de usuarios
	app.cargarUsuarios = function(){
		var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=Usuario";
        $("#tablaUsuario").DataTable({
            //Configura el idioma a espanol
                "language": {
                    "url": "../js/DataTables/Spanish.json"
                },
                "responsive": true,
                "select": 'single',
                //Configura los parametros para la llamada de ajax
                "ajax": {
                    "url": url,
                    "dataSrc": ""
                },
                "columns": [
                    {"data": "nombre"},
                    {"data": "clave",
                        "render": function (data, type, row, meta) {
                        	var c = atob(row.clave);
                        	return c;
                        }
                    },
                    {"data": "id"}
                ],
                "columnDefs": [
                    {
                        "targets": [ 2 ],
                        "visible": false,
                        "searchable": false
                    }
                ]
        });
	};

	app.actualizarDataTable = function (tipo){
        var tabla = $("#tabla" + tipo).DataTable();
        tabla.ajax.reload();
    };

	app.limpiarModal = function(){
		$("#nombre").val('');
		$("#clave").val('');
		$("#confirmarClave").val('');
		$("#permisosUsuario input[type='checkbox']").prop("checked", false);
	};

	app.buscarPermisos = function(idusuario){
		//Se buscan los permisos del usuario por su ID
		var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=UsuarioPermiso";
		var datosEnviar = ({id: idusuario});
		$.ajax({
			url: url,
			method: 'POST',
			dataType: 'json',
			data: datosEnviar,
			success: function(permisos){
				//Luego de obtener los permisos del usuario, se marcaran los checkbox correspondientes
				$.each(permisos, function(key, registro){
					$("#permisosUsuario input[id='" + registro.descripcion + "']").prop("checked", true);
					$("#permisosUsuario input[id='" + registro.descripcion + "']").removeAttr('disabled');
					$("#acciones" + registro.descripcion + " input[name='acciones"+ registro.descripcion +"']").removeAttr('disabled');
				});
			},
			error: function(){
				alert("Error al buscar los permisos del usuario");
			}
		});
	};

	app.agregarUsuario = function(){
		var permisos = new Array();
		var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Usuario";
		var datosEnviar = ({ nombre: btoa(btoa($("#nombre").val().toLowerCase().trim())) });
		$.ajax({
			url: url,
			method: 'POST',
			dataType: 'json',
			data: datosEnviar,
			success: function(data){
				if(data == false){
					//Se agregan los permisos seleccionados a un arreglo
					$("#permisosUsuario input[type='checkbox']").each(function(){
						if ($(this).is(':checked')) {
							permisos.push($(this).val());
						}
					});
					
					//Si no existe un usuario con el mismo nombre, se agrega el usuario
					url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=Usuario";
					datosEnviar = ({nombre: btoa(btoa($("#nombre").val().toLowerCase().trim())), clave: btoa(btoa($("#clave").val())), permisos: permisos});
					$.ajax({
						url: url,
						method: 'POST',
						dataType: 'json',
						data: datosEnviar,
						success: function(data){
							alert("Se agrego al usuario correctamente");
							app.actualizarDataTable('Usuario');
							$("#modalUsuario").modal('hide');
						},
						error: function(){
							alert("Error al agregar el usuario");
						}
					});
				} else{
					alert("Ya existe un usuario con ese nombre");
				}
			},
			error: function() {
				alert("Error al buscar el usuario");
			}
		});
	};

	app.modificarUsuario = function(idusuario){
		//Se crea una variable para guardar los nuevos permisos
		var permisosNuevos = new Array();
		//Se recorren todos los checkbox de los permisos para usuario para almacenar los seleccionados
		$.each($("#permisosUsuario input[type='checkbox']"), function(key, registro){
			if ($(this).is(':checked')) {
				permisosNuevos.push($(this).val());
			}
		});

		//Se buscan los permisos del usuario por su ID
		var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=UsuarioPermiso";
		var datosEnviar = ({id: idusuario});
		$.ajax({
			url: url,
			method: 'POST',
			dataType: 'json',
			data: datosEnviar,
			success: function(permisos){
				//Se crean dos listas para determinar que permisos seran agregados y cuales seran eliminados
				var agregarPermisos = new Array();
				var borrarPermisos = new Array();
				var p = new Array();
				//Se van a comparar los listados de permisos, los que ya tenia el usuario y los nuevos permisos
				//Se verifica que cada permiso de la lista de los permisos que ya tenia el usuario, se encuentra en la lista de los nuevos permisos,
				//ya que sino se encuentra dicho permiso debe ser eliminado 
				$.each(permisos, function(key, registro){
					p.push(registro.descripcion);
					if (!permisosNuevos.includes(registro.descripcion)) {
						borrarPermisos.push(registro.descripcion);
					}
				});
				//Se verifica que permiso de la lista de los permisos nuevos para el usuario, se encuentren en la lista de los permisos que ya tenia
				//para solo enviar los que no tenga para agregarlos
				$.each(permisosNuevos, function(key, registro){
					if (!p.includes(registro)) {
						agregarPermisos.push(registro);
					}
				});
				//Una vez separados los permisos a agregar y eliminar, seran enviados al backend
				url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=UsuarioPermiso";
				datosEnviar = ({idusuario: idusuario, agregarPermisos: agregarPermisos, borrarPermisos: borrarPermisos});
				$.ajax({
					url: url,
					method: 'POST',
					dataType: 'json',
					data: datosEnviar,
					success: function(data){
						alert("Se modificaron los permisos correctamente");
						url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=Usuario";
						datosEnviar = ({clave: btoa(btoa($("#clave").val())), idusuario: idusuario});
						$.ajax({
							url: url,
							method: 'POST',
							dataType: 'json',
							data: datosEnviar,
							success: function(data){
								alert("Se modifico la clave del usuario");
								app.actualizarDataTable('Usuario');
								$("#modalUsuario").modal('hide');
								$("#nombre").removeAttr('disabled');
							},
							error: function(){
								alert("Error al modificar la clave del usuario");
							}
						});
					},
					error: function(){
						alert("Error al enviar los permisos a modificar");
					}
				});
			},
			error: function(){
				alert("Error al buscar los permisos del usuario");
			}
		});
		
	};

	app.oyenteCheckbox = function(){
		//Oyentes para los cambios en los checkbox
		$("#rrhh").change(function() {
			if ($(this).is(":checked")) {
				$("#accionesrrhh input[name='accionesrrhh']").removeAttr('disabled');
			} else {
				//name='accionesrrhh'
				$("#accionesrrhh input[type='checkbox']").attr('disabled', 'disabled');
				$("#accionesrrhh input[type='checkbox']").prop("checked", false);
			}
 		});

		$("#linkLegajos").change(function() {
			if ($(this).is(":checked")) {
				$("#accioneslinkLegajos input[type='checkbox']").removeAttr('disabled');
			} else {
				$("#accioneslinkLegajos input[type='checkbox']").attr('disabled', 'disabled');
				$("#accioneslinkLegajos input[type='checkbox']").prop("checked", false);
			}
 		});

 		$("#linkVacaciones").change(function() {
			if ($(this).is(":checked")) {
				$("#accioneslinkVacaciones input[name='accioneslinkVacaciones']").removeAttr('disabled');
			} else {
				$("#accioneslinkVacaciones > input[type='checkbox']").attr('disabled', 'disabled');
				$("#accioneslinkVacaciones input[type='checkbox']").prop("checked", false);
				
			}
 		});

 		$("#linkPedidoVacaciones").change(function() {
			if ($(this).is(":checked")) {
				$("#accioneslinkPedidoVacaciones input[type='checkbox']").removeAttr('disabled');
			} else {
				$("#accioneslinkPedidoVacaciones input[type='checkbox']").attr('disabled', 'disabled');
				$("#accioneslinkPedidoVacaciones input[type='checkbox']").prop("checked", false);
			}
 		});

 		$("#linkDiasCtaLicencia").change(function() {
			if ($(this).is(":checked")) {
				$("#accioneslinkDiasCtaLicencia input[type='checkbox']").removeAttr('disabled');
			} else {
				$("#accioneslinkDiasCtaLicencia input[type='checkbox']").attr('disabled', 'disabled');
				$("#accioneslinkDiasCtaLicencia input[type='checkbox']").prop("checked", false);
			}
 		});

 		$("#linkLicenciaVacaciones").change(function(){
			if ($(this).is(":checked")) {
				$("#accioneslinkLicenciaVacaciones input[type='checkbox']").removeAttr('disabled');
			} else {
				$("#accioneslinkLicenciaVacaciones input[type='checkbox']").attr('disabled', 'disabled');
				$("#accioneslinkLicenciaVacaciones input[type='checkbox']").prop("checked", false);
			}
 		});

 		$("#linkLiquidacion").change(function(){
			if ($(this).is(":checked")) {
				$("#accioneslinkLiquidacion input[type='checkbox']").removeAttr('disabled');
			} else {
				$("#accioneslinkLiquidacion input[type='checkbox']").attr('disabled', 'disabled');
				$("#accioneslinkLiquidacion input[type='checkbox']").prop("checked", false);
			}
 		});

 		$("#usuarios").change(function(){
 			if ($(this).is(":checked")) {
 				$("#accionesusuarios input[type='checkbox']").removeAttr('disabled');
 			} else {
 				$("#accionesusuarios input[type='checkbox']").attr('disabled', 'disabled');
				$("#accionesusuarios input[type='checkbox']").prop("checked", false);
 			}
 		});
	};

	app.oyentes = function(tipo){

		//Se almacenan los datos de la tabla en una variable para utilizar sus metodos
        var tabla = $("#tabla" + tipo).DataTable();

        //Variable utilizada para guardar los datos de la fila seleccionada
        var fila = null;

        //Variable utilizada para guardar los permisos del usuario
        var permisosUsuario = null;

        //Se cargan los datos de la fila seleccionada para acceder a cada uno de ellos
        $("#tabla" + tipo + " tbody").on('click', 'tr', function(){
            fila = tabla.row(this).data();
        });

		//Botones Usuario
		$("#agregarUsuario").on('click', function(){
			//Se muestra el modal para agregar un usuario
			app.limpiarModal();
			$("#accionFormUsuario").val('agregar');
			$("#tituloModalUsuario").html('<b>Agregando Usuario</b>');
			$("#formUsuario").data('bootstrapValidator').resetForm();
			$("#modalUsuario").modal({show: true});
			app.oyenteCheckbox();
		});

		$("#modificarUsuario").on('click', function(){
			//Se muestra el modal para modificar un usuario
			app.limpiarModal();
			$("#accionFormUsuario").val('modificar');
			$("#tituloModalUsuario").html('<b>Modificando Usuario</b>');
			$("#formUsuario").data('bootstrapValidator').resetForm();
			app.oyenteCheckbox();
			//Se completan los campos con los datos de la fila seleccionada
			$("#nombre").val(fila['nombre']);
			$("#nombre").attr('disabled', 'disabled');
			$("#clave").val(atob(fila['clave']));
			$("#confirmarClave").val(atob(fila['clave']));

			//Se activaran las casillas correspondientes a los permisos que tenga el usuario y se duvuelve el listado de los permisos
			app.buscarPermisos(fila['id']);

			$("#modalUsuario").modal({show: true});
		});

		//Validacion Formulario Usuario
		$("#formUsuario").bootstrapValidator({
            excluded: [':disabled', ':hidden', ':not(:visible)'],
            feedbackIcons: {
		        valid: 'glyphicon glyphicon-ok',
		        invalid: 'glyphicon glyphicon-remove',
		        validating: 'glyphicon glyphicon-refresh'
		    },
		    live: 'enabled',
		    message: 'Esa opcion no es valida',
		    submitButtons: 'button[type="submit"]',
		    trigger: null,
		    fields:{
		    	nombre: {
            	    validators: {
            	        notEmpty: {
            	            message: 'Debe completar el nombre del usuario'
            	        }
            	    }
            	},
            	clave: {
            		validators:{
            			notEmpty:{
            				message: 'Debe ingresar una clave'
            			}
            		}

            	},
            	confirmarClave:{
            		validators:{
            			notEmpty:{
            				message: 'Debe ingresar la clave nuevamente'
            			},
            			identical:{
            				field: 'clave',
            				message: 'Debe confirmar el password'
            			}
            		}
            	},
            	'permiso[]':{
            		validators:{
            			choice:{
            				min: 1,
            				message: 'Debe seleccionar los permisos para el usuario'
            			}
            		}
            	}
		    }
        })
            .on('error.form.bv', function(e){
                alert("Debe completar los campos requeridos");
            })
            .on('success.form.bv', function(e){
                e.preventDefault();
                switch($("#accionFormUsuario").val()) {

                	case 'agregar':
                		app.agregarUsuario();
                		break;

                	case 'modificar':
                		app.modificarUsuario(fila['id']);
                		break;

                	default:
                		alert("La accion no es valida");
                }
                
        });

	};

};