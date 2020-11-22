function funcionesEmpleado(app){
    
	//Se carga el DataTable de los empleados
	app.cargarEmpleados = function(){
		var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=Empleado";
		$("#tablaEmpleados").DataTable({
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
                //Configura las columnas que va tener la tabla
                "columns": [
                    {"data": "legajo"},
                    {"data": "apellido"},
                    {"data": "nombre"},
                    {"data": "dni"},
                    {"data": "sexo"},
                    {"data": "ingreso",
                        "render": function (data, type, row, meta) {
                            var i = row.ingreso.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            return i;
                        }
                    },
                    {"data": "seccion"},
                    {"data": "delegacion"},
                    {"data": "nacimiento",
                        "render": function (data, type, row, meta) {
                            var n = row.nacimiento.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            return n;
                        }
                    },
                    {"data": "cuil"},
                    {"data": "domicilio"},
                    {"data": "telefono"},
                    {"data": "id"}
                ],
                "columnDefs": [
                    {
                        "targets": [ 12 ],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [ 0 ],
                        "searchable": true
                    }
                ]
		});
	};

    app.cargarAuditoria = function(data){
        $("#tablaAuditoria").DataTable({
            "destroy": true,
            //Configura el idioma a espanol
            "language": {
                "url": "../js/DataTables/Spanish.json"
            },
            "responsive": true,
            "select": 'single',
            //Se asignan los datos por parametros para completar la tabla
            "data": data,
            "columns": [
                {"data": "usuario"},
                {"data": "accion"},                
                {"data": "fecha",
                    "render": function (data, type, row, meta) {
                        var i = row.fecha.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                        return i;
                    }
                }
            ]
        });
    };

    app.actualizarTablaEmpleados = function(){
        var tablaEmpleados = $("#tablaEmpleados").DataTable();
        tablaEmpleados.ajax.reload();
    };

    app.listarSecciones = function(){
        var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=Seccion";
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            success: function(data){
                $.each(data,function(key, registro) {
                    $("#seccion").append("<option value="+registro.id+">"+registro.nombre+"</option>");
                });
            },
            error: function(data){
                alert("Error al cargar las secciones " + data);
            }
        });
    };

    app.listarDelegaciones = function(){
        var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=Delegacion";
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            success: function(data){
                $.each(data,function(key, registro) {
                    $("#delegacion").append("<option value="+registro.id+">"+registro.nombre+"</option>");
                });
            },
            error: function(data){
                alert("Error al cargar las delegaciones " + data);
            }
        });
    };

    app.limpiarModal = function(){
        $("#idpersona").val("0");
        $("#legajo").val('');
        $("#apellido").val('');
        $("#nombre").val('');
        $("#dni").val('');
        $("#sexo").val('');
        $("#cuil").val('');
        $("#fechaNacimiento").val('');
        $("#telefono").val('');
        $("#domicilio").val('');
        $("#fechaIngreso").val('');
        $("#seccion").val("1");
        $("#delegacion").val("1");
    };

    app.guardarEmpleado = function(){
        //Se verifica si el numero de legajo ya se encuentra ingresado
        var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Empleado";
        var datosEnviar = $("#formEmpleado").serialize();
        $.ajax({
            url: url,
            async: true,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(datosRecibidos){
                //Si no se encuentra el numero de legajo, se busca si existe una persona por el numero de dni
                if(datosRecibidos == false){
                    url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Persona";
                    $.ajax({
                      url: url,
                      async: true,
                      method: 'POST',
                      dataType: 'json',
                      data: datosEnviar,
                     success: function(datosRecibidos){
                        if(datosRecibidos == false){
                            //Si no hay una persona con el mismo dni se procede a agregar el legajo con esa persona
                            url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=Empleado";
                            $.ajax({
                                url: url,
                                async: true,
                                method: 'POST',
                                dataType: 'json',
                                data: datosEnviar,
                                success: function(datosRecibidos){
                                    alert("El empleado fue agregado correctamente");
                                    $("#modalEmpleado").modal('hide');
                                    app.limpiarModal();
                                    app.actualizarTablaEmpleados();
                                    $("#formEmpleado").data('bootstrapValidator').resetForm();
                                },
                                error: function(datosRecibidos){
                                    alert("Error al ingresar el empleado");
                                }
                            });
                        //Se verifica si la persona por dni ya tenga un legajo para avisarle al usuario
                        }else if(datosRecibidos['dni'] == $("#dni").val()){
                            alert("Esa persona ya tiene un legajo");
                        }else{
                            //Si existe una persona se le da la opcion de modificar los datos o conservar los datos 
                            if(confirm("Ya existe una persona con ese DNI ¿Desea modificar los datos?")){
                                $("#idpersona").val(datosRecibidos['id']);
                                datosEnviar = $("#formEmpleado").serialize();
                                datosEnviar += "&modificar=true";
                                url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=Empleado";
                                $.ajax({
                                    url: url,
                                    async: true,
                                    method: 'POST',
                                    dataType: 'json',
                                    data: datosEnviar,
                                    success: function(datosRecibidos){
                                        alert("Se modifico la persona y se agrego el legajo correctamente");
                                        $("#modalEmpleado").modal('hide');
                                        app.limpiarModal();
                                        app.actualizarTablaEmpleados();
                                        $("#formEmpleado").data('bootstrapValidator').resetForm();
                                    },
                                    error: function(datosRecibidos){
                                        alert("Error al cambiar el empleado y agregar el legajo");
                                    }
                                });
                            }else{
                                $("#idpersona").val(datosRecibidos['id']);
                                datosEnviar = $("#formEmpleado").serialize();
                                datosEnviar += "&modificar=false";
                                url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=Empleado";
                                $.ajax({
                                    url: url,
                                    async: true,
                                    method: 'POST',
                                    dataType: 'json',
                                    data: datosEnviar,
                                    success: function(datosRecibidos){
                                        alert("Se agrego el legajo correctamente, sin modificar los datos de la persona");
                                        $("#modalEmpleado").modal('hide');
                                        app.limpiarModal();
                                        app.actualizarTablaEmpleados();
                                        $("#formEmpleado").data('bootstrapValidator').resetForm();
                                    },
                                    error: function(datosRecibidos){
                                        alert("Error al agregar el legajo, sin modificar los datos de la persona");
                                    }
                                });    
                            }
                        }
                      },
                      error: function(datosRecibidos){
                        alert("Error al buscar la persona");
                      }  
                    });
                }else if(datosRecibidos['dni'] == $("#dni").val()){
                    alert("Ya existe el numero de legajo con esa persona");
                }else{
                    alert("El numero de legajo ya se encuentra registrado");
                }
            },
            error: function(data){
                alert("Error al buscar el empleado");
            }
        });
    };

    app.modificarEmpleado = function(){
        if (confirm("¿Esta seguro que desea modificar los datos del empleado?")){
            var url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=Empleado";
            var datosEnviar = $("#formEmpleado").serialize();
            console.log(datosEnviar);
            $.ajax({
                url: url,
                method: 'POST',
                data: datosEnviar
            })
                .done(function(data){
                    alert("Se modificaron los datos del empleado");
                    $("#modalEmpleado").modal('hide');
                    app.limpiarModal();
                    $("#legajo").removeAttr("readonly");
                    app.actualizarTablaEmpleados();
                    $("#formEmpleado").data('bootstrapValidator').resetForm();
                })
                .fail(function(data){
                    alert("Error al modificar el Empleado");
                });
        }else{
            alert("Se conservan los datos el empleado");
        }
    };

    app.eliminarEmpleado = function(legajo){
        if(confirm("¿Esta seguro que desea eliminar el empleado?")){
            var url = "../controlador/ruteador/Ruteador.php?accion=eliminar&Formulario=Empleado";
            var datosEnviar = {legajo: legajo};
            $.ajax({
                url: url,
                method: "POST",
                data: datosEnviar,
                success: function (datosRecibidos) {
                    alert('El empleado se elimino exitosamente');
                    app.actualizarTablaEmpleados();
                    $("#formEmpleado").data('bootstrapValidator').resetForm();
                },
                error: function (datosRecibidos) {
                    alert('Hubo un error al eliminar el empleado');
                }
            });
        }
    };

	app.oyentes = function(){

        //Se almacenan los datos de la tabla en una variable para utilizar sus metodos
        var tabla = $("#tablaEmpleados").DataTable();
        var control = false;

        //Variable utilizada para guardar los datos de la fila seleccionada
        var fila = null;

        //Se cargan los datos de la fila seleccionada para acceder a cada uno de ellos
        $("#tablaEmpleados tbody").on('click', 'tr', function(){
            fila = tabla.row(this).data();
        });

		$("#agregarEmpleado").on('click', function(){
            app.limpiarModal();
            $("#legajo").removeAttr("readonly");
            $("#dni").removeAttr("readonly");
            $("#fechaIngreso").removeAttr("readonly");
            $("#tituloModalEmpleado").html("<b>Nuevo empleado</b>");
			$("#modalEmpleado").modal({show: true});
		});

		$("#modificarEmpleado").on('click', function(){
            if (fila == null) {
                alert("Debes seleccionar un empleado");
            }else{
                $("#tituloModalEmpleado").html("<b>Modificando un empleado</b>");
                $("#idpersona").val(fila['id']);
                $("#legajo").val(fila['legajo']);
                $("#legajo").attr("readonly","readonly");
                $("#apellido").val(fila['apellido']);
                $("#nombre").val(fila['nombre']);
                $("#dni").val(fila['dni']);
                $("#dni").attr("readonly","readonly");
                $("#sexo").val(fila['sexo']);
                $("#cuil").val(fila['cuil']);
                $("#fechaIngreso").val(fila['ingreso']);
                $("#fechaIngreso").attr("readonly","readonly");
                $("#seccion option").each(function(){
                    if($(this).text() == fila['seccion']){
                        $("#seccion").val($(this).val());
                    }
                });
                $("#delegacion option").each(function(){
                    if($(this).text() == fila['delegacion']){
                        $("#delegacion").val($(this).val());
                    }
                });
                $("#fechaNacimiento").val(fila['nacimiento']);
                $("#telefono").val(fila['telefono']);
                $("#domicilio").val(fila['domicilio']);                
                $("#modalEmpleado").modal({show: true});
            }
		});

        $("#eliminarEmpleado").on('click', function(){
            if (fila == null) {
                alert("Debes seleccionar un empleado");
            }else{
                app.eliminarEmpleado(fila['legajo']);
            }
        });
        
        $("#cerrarModalEmpleado").on('click', function(){
            app.limpiarModal();
            $("#legajo").removeAttr("readonly");
            $("#formEmpleado").data('bootstrapValidator').resetForm();
        });

        $("#cruzModalEmpleado").on('click', function(){
            app.limpiarModal();
            $("#legajo").removeAttr("readonly");
            $("#formEmpleado").data('bootstrapValidator').resetForm();
        });

        $("#AuditoriaEmpleados").on('click', function(){
            if (fila != null) {
                var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Auditoria";
                var datosEnviar = ({tabla: "empleado", idregistro: fila['legajo']});
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: datosEnviar,
                    success: function(data){
                        app.cargarAuditoria(data);
                        $("#modalAuditoriaEmpleados").modal({show: true});
                    },
                    error: function(data){
                        alert("Error al cargar los datos de auditoria");
                    }
                });
            }else{
                alert("Debe seleccionar un empleado");
            }  
        });

        //Se configuran las validaciones de bootstrap
        $("#formEmpleado").bootstrapValidator({
            excluded: []
        })
            .on('error.form.bv', function(e){
                alert("Debe completar todos los campos");
            })
            .on('success.form.bv', function(e){
                e.preventDefault();
                if($("#idpersona").val() == "0"){
                app.guardarEmpleado();
                }else {
                    app.modificarEmpleado();
                    $("#legajo").removeAttr("readonly");
                    $("#dni").removeAttr("readonly");
                    $("#fechaIngreso").removeAttr("readonly");
                }
        });                       

    };

};