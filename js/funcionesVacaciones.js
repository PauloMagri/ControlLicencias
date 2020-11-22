function funcionesVacaciones(app){
	
    //Se carga el datatables de las licencia de vacaciones
    app.cargarLicenciaVacaciones = function(){
        var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=LicenciaVacaciones";
        $("#tablaLicenciaVacaciones").DataTable({
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
                    {"data": "legajo"},
                    {"data": "apellido"},
                    {"data": "nombre"},
                    {"data": "antiguedad"},
                    {"data": "anio"},
                    {"data": "dias"},
                    {"data": "pendientes"},
                    {"data": "id"}
                ],
                "columnDefs": [
                    {
                        "targets": [ 7 ],
                        "visible": false,
                        "searchable": false
                    }
                ]
        });
    };

	//Se carga el datatable de los pedidos de vacaciones
	app.cargarPedidosVacaciones = function(){
		var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=PedidoVacaciones";
		$("#tablaPedidoVacaciones").DataTable({
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
                    {"data": "id"},
                    {"data": "fecha",
                        "render": function (data, type, row, meta) {
                            var f = row.fecha.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            return f;
                        }
                    },
                    {"data": "legajo"},
                    {"data": "apellido"},
                    {"data": "nombre"},
                    {"data": "ingreso",
                        "render": function (data, type, row, meta) {
                            var i = row.ingreso.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            return i;
                        }
                    },
                    {"data": "idlicenciavacaciones"},
                    {"data": "dias"},
                    {"data": "anio"},
                    {"data": "desde",
                        "render": function (data, type, row, meta) {
                            if(row.desde != null){
                                var d = row.desde.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                                return d;
                            }else{
                                return null;
                            }
                        }
                    },
                    {"data": "hasta",
                        "render": function (data, type, row, meta) {
                            if(row.hasta != null){
                                var h = row.hasta.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                                return h;
                            }else{
                                return null;
                            }
                        }
                    },
                    {"data": "cantidaddias"},
                    {"data": "pendientes"}
                ],
                "columnDefs": [
                    {
                        "targets": [ 6 ],
                        "visible": false,
                        "searchable": false
                    }
                ]
		});
	};

    //Se carga el datatable de los pedidos de vacaciones
    app.cargarDiasCtaLicencia = function(){
        var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=DiasCtaLicencia";
        $("#tablaDiasCtaLicencia").DataTable({
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
                    {"data": "id"},
                    {"data": "fecha",
                        "render": function (data, type, row, meta) {
                            var f = row.fecha.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            return f;
                        }
                    },
                    {"data": "legajo"},
                    {"data": "apellido"},
                    {"data": "nombre"},
                    {"data": "ingreso",
                        "render": function (data, type, row, meta) {
                            var i = row.ingreso.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            return i;
                        }
                    },
                    {"data": "idlicenciavacaciones"},
                    {"data": "dias"},
                    {"data": "anio"},
                    {"data": "desde",
                        "render": function (data, type, row, meta) {
                            if(row.desde != null){
                                var d = row.desde.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                                return d;
                            }else{
                                return null;
                            }
                        }
                    },
                    {"data": "hasta",
                        "render": function (data, type, row, meta) {
                            if(row.hasta != null){
                                var h = row.hasta.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                                return h;
                            }else{
                                return null;
                            }
                        }
                    },
                    {"data": "cantidaddias"},
                    {"data": "pendientes"}
                ],
                "columnDefs": [
                    {
                        "targets": [ 6 ],
                        "visible": false,
                        "searchable": false
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

    var arrayMeses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

    app.cargarLiquidaciones = function(){
        var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=Liquidacion";
        $("#tablaLiquidaciones").DataTable({
            "destroy": true,
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
                {"data": "legajo"},                
                {"data": "apellido"},                
                {"data": "nombre"},                
                {"data": "id"},                
                {"data": "mes",
                    "render": function (data, type, row, meta) {
                        var i = arrayMeses[row.mes];
                        return i;
                    }
                },
                {"data": "dias"},
                {"data": "tipo"},
                {"data": "idpedido"}
            ],
            "columnDefs": [
                    {
                        "targets": [ 3 ],
                        "visible": false,
                        "searchable": false
                    }
            ]
        });
    };

    app.cargarEmpleadosLicencia = function(data){
        $("#tablaEmpleadosLicencia").DataTable({
            "destroy": true,
            //Configura el idioma a espanol
            "language": {
                "url": "../js/DataTables/Spanish.json"
            },
            "responsive": true,
            "select": 'single',
            "data": data,
            "columns": [
                {"data": "legajo"},                
                {"data": "apellido"},                
                {"data": "nombre"},                
                {"data": "desde",
                    "render": function (data, type, row, meta) {
                        var i = row.desde.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                        return i;
                    }
                },                
                {"data": "hasta",
                    "render": function (data, type, row, meta) {
                        var i = row.hasta.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                        return i;
                    }
                }
            ]
        });
    };

	//Actualiza la tabla de la vista usando DataTable
    app.actualizarDataTable = function (tipo){
        var tabla = $("#tabla" + tipo).DataTable();
        tabla.ajax.reload();
    };

    app.listarLicencias = function(tipo){
    	var fecha = new Date();
		var anio = fecha.getFullYear();
        $("#" + tipo).empty();
        $("#" + tipo).append("<option value="+ ((anio-2)+'/'+(anio-1)) +">"+ ((anio-2)+'/'+(anio-1)) +"</option>");
    	$("#" + tipo).append("<option value="+ ((anio-1)+'/'+anio) +">"+ ((anio-1)+'/'+anio) +"</option>");
		$("#" + tipo).append("<option value="+ (anio+'/'+(anio+1)) +" selected>"+ (anio+'/'+(anio+1)) +"</option>");
		$("#" + tipo).append("<option value="+ ((anio+1)+'/'+(anio+2)) +">"+ ((anio+1)+'/'+(anio+2)) +"</option>");
        $("#" + tipo).append("<option value="+ ((anio+2)+'/'+(anio+3)) +">"+ ((anio+2)+'/'+(anio+3)) +"</option>");    	
    };

    app.listarSecciones = function(){
        var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=Seccion";
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            success: function(data){
                $.each(data, function(key, registro) {
                    $("#seccion").append("<option value="+registro.id+">"+registro.nombre+"</option>");
                });
            },
            error: function(data){
                alert("Error al cargar las secciones " + data);
            }
        });
    };

    app.autocompletar = function(legajo, apellido, nombre){
        //Se van a autocompletar los campos de apellido y nombre en el modal para agregar un nuevo pedido de vacaciones en funcion del legajo
        $("#" + legajo).focusout(function(){
            $("#" + apellido).val('');
            $("#" + nombre).val('');
            var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Empleado";
            var datosEnviar = ({legajo: $("#" + legajo).val()});
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: datosEnviar,
                success: function(data){
                    if(data == false){
                        $("#" + apellido).val("No existe ese legajo");
                        $("#" + nombre).val("No existe ese legajo");
                    }else{
                        $("#" + apellido).val(data.apellido);
                        $("#" + nombre).val(data.nombre);
                    }
                },
                error: function(){
                    alert("Error al buscar el empleado");
                }
            });
        });
    };

    app.calcularDias = function(){
        $("#hasta").focusout(function(){
            if($("#desde").val() <= $("#hasta").val()){
                var d = new Date($("#desde").val()),
                    h = new Date($("#hasta").val());
                var dias = Math.round((h - d) / (1000*60*60*24)) + 1;
                $("#dias").val(dias);
            }else{
                $("#dias").val("El inicio de vacaciones debe ser anterior a su terminacion");
            }
        });
    };

    app.limpiarModal = function(tipo){

        // Modal pedido vacaciones

        if(tipo == "agregar"){
            $("#fechaapv").val('');
            $("#legajoapv").val('');
            $("#apellidoapv").val('');
            $("#nombreapv").val('');
            $("#licencia").val('');
            //$("#formAgregarPedidoVacaciones").data('bootstrapValidator').resetForm();
        }
        if(tipo == "modificar"){
            $("#idpedidovacaciones").val('');
            $("#fecha").val('');        
            $("#legajo").val('');
            $("#apellido").val('');
            $("#nombre").val('');
            $("#idlicenciavacaciones").val('');
            $("#licencia").val('');
            $("#desde").val('');
            $("#hasta").val('');
            $("#dias").val('');
            //$("#formModificarPedidoVacaciones").data('bootstrapValidator').resetForm(); 
        }

        // Modal diasCtaLicencia

        if(tipo == "agregardc"){
            $("#fechaadc").val('');
            $("#legajoadc").val('');
            $("#apellidoadc").val('');
            $("#nombreadc").val('');
            $("#licencia").val('');
        }

        if(tipo == "modificardc"){
            $("#iddiasctalicencia").val('');
            $("#fecha").val('');        
            $("#legajo").val('');
            $("#apellido").val('');
            $("#nombre").val('');
            $("#idlicenciavacaciones").val('');
            $("#licencia").val('');
            $("#desde").val('');
            $("#hasta").val('');
            $("#dias").val('');
        }

    };

    app.calcularAntiguedad = function(ingreso, licencia){
        //Se obtienen los dias de vacaciones corespondientes a la fecha del 31/12 del año corriente
        var fechaVacaciones = new Date(licencia.substr(0,4), 11, 31);
        //Se convierte en un objeto Date el parametro
        var i = ingreso.split('-').join(',');
        var fechaIngreso = new Date(i);
        
        //Se obtiene los años y meses de antiguedad
        var meses = fechaVacaciones.getMonth() - fechaIngreso.getMonth();

        if(meses < 0){
            if(fechaVacaciones.getFullYear() > fechaIngreso.getFullYear()){
                var anios = (fechaVacaciones.getFullYear() - fechaIngreso.getFullYear()) - 1;
                meses = 12 + meses;
            }else{
                var anios = 0;
                meses = 12 + meses;
            }
            
        }else{
            if(fechaVacaciones.getFullYear() > fechaIngreso.getFullYear()){
                var anios = fechaVacaciones.getFullYear() - fechaIngreso.getFullYear();
            }else{
                var anios = 0;
            }
        }
        
        var diasVacaciones = null;

        if(anios <= 0){
            if(meses < 6){
                var d = Math.round((fechaVacaciones - fechaIngreso) / (1000*60*60*24));
                diasVacaciones = Math.round(d/20);
                if(diasVacaciones < 0){
                    diasVacaciones *= -1;
                }
            }else{
                diasVacaciones = 14;
            }
        }else if(anios > 0 && anios < 5){
            diasVacaciones = 14;
        }else if(anios >= 5 && anios < 10){
            diasVacaciones = 21;
        }else if(anios >=10 && anios < 20){
            diasVacaciones = 28;
        }else if(anios >= 20){
            diasVacaciones = 35;
        }

        var antiguedad = ({anios: anios, meses: meses, diasVacaciones: diasVacaciones});
        return antiguedad;
    };

    // FUNCIONES LICENCIA VACACIONES

    app.generarLicencias = function(){
        //Se obtiene el anio actual para pasarlo como parametros para generar las licencias
        var fecha = new Date();
        var anio = fecha.getFullYear() + '/' + (fecha.getFullYear()+1);
        var antiguedad = null;
        //Para generar las licencias anuales primero se va a consultar la lista de todos los empleados
        var url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=Empleado";
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            beforeSend: function() {
                $("#modalProcesando").modal('show').css({
                        'margin-top': function () {
                            return -($(this).height() / 2);
                        },
                        'margin-left': function () {
                            return -($(this).width() / 2);
                        }
                });
            },
            success: function(arrayEmpleados){
                //Luego de obtener el listado de los empleados, se verificara si ese empleado ya tiene una licencia para el año actual, para agregar la licencia o no
                url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=LicenciaVacaciones";
                $.each(arrayEmpleados, function(key, registro){
                    //Para determinar la vacaciones tomar hasta el 31/12 del año corriente
                    antiguedad = app.calcularAntiguedad(registro.ingreso, anio);
                    var datosEnviar = ({anio: anio, dias: antiguedad.diasVacaciones, pendientes: antiguedad.diasVacaciones, legajo: registro.legajo, antiguedad: antiguedad.anios + " años, " + antiguedad.meses + " meses"});
                    //Se realiza la busqueda de licencias del empleado
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: datosEnviar,
                        dataType: 'json',
                        success: function(data){
                            //Si no se encontro una licencia del empleado en el año corriente se procede a agregarla
                            if(data == false){
                                url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=LicenciaVacaciones";
                                $.ajax({
                                    url: url,
                                    method: 'POST',
                                    data: datosEnviar,
                                    dataType: 'json',
                                    success: function(data){
                                        //console.log("Se agrego la licencia " + registro.apellido);
                                    },
                                    error: function(data){
                                        //console.log("Error al agregar la licencia " + registro.apellido);
                                    }
                                });
                            }
                        },
                        error: function(){
                            alert("Error al generar las licencias de vacaciones");
                        }
                    });
                });
                app.actualizarDataTable("LicenciaVacaciones");
                $("#modalProcesando").modal('hide');
            },
            error: function(){
                alert("Error al buscar los empleados");
            }
        });
    };

    app.agregarLicenciaVacaciones = function(){
        //Se va a agregar un licencia para un solo empleado
        var antiguedad = null;
        var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Empleado";
        var datosEnviar = ({legajo: $("#legajoapv").val()});
        console.log(datosEnviar);
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(empleado){
                if(empleado != false){
                    //Luego de obtener el empleado, se verificara si ese empleado ya tiene una licencia para el año en la que desea generar, para agregar la licencia o no
                    url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=LicenciaVacaciones";    
                    datosEnviar = ({legajo: $("#legajoapv").val(), anio: $("#licencia").val()});
                    //Se realiza la busqueda de licencias del empleado
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: datosEnviar,
                        dataType: 'json',
                        success: function(data){
                            //Si no se encontro una licencia del empleado en el año corriente se procede a agregarla
                            if(data == false){
                                url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=LicenciaVacaciones";
                                antiguedad = app.calcularAntiguedad(empleado.ingreso, $("#licencia").val());
                                datosEnviar = ({anio: $("#licencia").val(), dias: antiguedad.diasVacaciones, pendientes: antiguedad.diasVacaciones, legajo: empleado.legajo, antiguedad: antiguedad.anios + " años, " + antiguedad.meses + " meses"});    
                                $.ajax({
                                    url: url,
                                    method: 'POST',
                                    data: datosEnviar,
                                    dataType: 'json',
                                    success: function(data){
                                        app.actualizarDataTable("LicenciaVacaciones");
                                        $("#modalAgregarLicenciaVacaciones").modal('hide');
                                    },
                                    error: function(data){
                                        alert("Error al agregar la licencia " + empleado.apellido);
                                    }
                                });
                            } else{
                                alert("Ese emplado ya tiene una licencia para ese año");
                            }
                        },
                        error: function(){
                            alert("Error al agregar la licencia de vacaciones");
                        }
                    });
                }else{
                    alert("No existe un empleado con ese numero de legajo");
                }
                
            },
            error: function(){
                alert("Error al buscar el empleado");
            }
        });
    };

    app.modificarLicencia = function(idlicenciavacaciones, dias, pendientes){
        //Funcion utilizada para devolver los dias pendientes tomados, al momento de modificar la solicitud de dias pendientes
        var url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=LicenciaVacaciones";
        var datosEnviar = ({idlicenciavacaciones: idlicenciavacaciones, dias: dias, pendiente: pendientes});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                console.log("Se devolvieron los dias a la licencia");
            },
            error: function(data){
                console.log("Error al devolver los dias a la licencia");
            }
        });
    };

    // FUNCIONES PEDIDO VACACIONES

    app.guardarPedidoVacaciones = function(){
        //Antes de agregar el pedido vacaciones se busca la licencia del empleado
        var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=LicenciaVacaciones";
        var datosEnviar = ({legajo: $("#legajoapv").val(), anio: $("#licencia").val()});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                if(data == false){
                    alert("Ese empleado no tiene una licencia de vacaciones " + $("#licencia").val() + ", porfavor genere las licencias nuevamente");
                }else if(data.pendientes > 0){
                    //Si se encuentra la licencia y aun tiene dias pendientes se agrega el nuevo pedido
                    var url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=PedidoVacaciones";
                    var datosEnviar = $("#formAgregarPedidoVacaciones").serialize();
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: datosEnviar,
                        success: function(data){
                            //Una vez ingresado el pedido de vacaciones se genera el pdf
                            $("#formulariopedidovacaciones").val('pedido');
                            $("#idpv").val(data[0].idpedidovacaciones);
                            var f = (data[0].fecha).replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            $("#f").val(f);
                            $("#leg").val(data[0].legajo);
                            $("#ap").val(data[0].apellido);
                            $("#nom").val(data[0].nombre);
                            var ingreso = (data[0].ingreso).replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            $("#ing").val(ingreso);
                            $("#d").val(data[0].dias);
                            $("#a").val(data[0].anio);
                            $("#imprimir").submit();

                            app.actualizarDataTable("PedidoVacaciones");
                            $("#modalAgregarPedidoVacaciones").modal('hide');
                            app.limpiarModal("agregar");
                        },
                        error: function(data){
                            alert("Error al agregar el pedido de vacaciones");
                        }
                    });
                }else{
                    alert("Al empleado no le quedan dias pendientes para esa licencia");
                }
            },
            error: function(data){
                alert("Error al buscar la licencia");
            }
        });        
    };

    app.generarPedidoVacaciones = function(){
        //Se generaran los pedidos de vacaciones automaticamente por la seccion, para luego enviarlos para ser impresos
        var arrayPV = new Array();
        var url = "../controlador/ruteador/Ruteador.php?accion=buscarLicencias&Formulario=LicenciaVacaciones";
        var datosEnviar = ({tabla: "empleado", criterio: "idseccion", idseccion: $("#seccion").val(), anio: $("#licenciagpv").val()});
        console.log(datosEnviar);
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(arrayLicencias){
                //Se obtienen todas las licencias de la seccion y anio seleccionados en el formulario
                url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=PedidoVacaciones";
                $.each(arrayLicencias, function(key, registro){
                    datosEnviar = ({legajo: registro.legajo, licencia: registro.anio, fecha: $("#fechagpv").val()});
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: datosEnviar,
                        success: function(pedido){
                            //Se utilizan los datos de las licencias para generar los pedidos de vacaciones
                            //Cada pedido se ingresa en un arreglo para luego imprimirlos
                            arrayPV.push(pedido);
                        },
                        error: function(){
                            console.log("Error al agregar el pedido de " + registro.apellido);
                        }
                    });
                });
            },
            error: function(){
                alert("Error al buscar las licencias de vacaciones");
            }
        });

        //Una vez ingresados todos los pedidos se enviaran para ser impresos
        url = "../controlador/reportes/ImprimirPVSeccion.php";
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: arrayPV,
            success: function(data){
                //console.log("Se enviaron los pedidos a imprimir");
            },
            error: function(data){
                console.log("Error al enviar los pedidos para imprimir");
            }
        });

    };

    app.modificarPedidoVacaciones = function(idlv = null, d = null, p = null){
        //Antes de modificar el pedido de vacaciones se buscara la licencia del empleado del año correspondiente para asegurarse de que no se exedan los dias de vacaciones
        var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=LicenciaVacaciones";
        var datosEnviar = ({legajo: $("#legajo").val(), anio: $("#anio").val()});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(licencia){
                if(licencia == false){
                    alert("Ese empleado no tiene una licencia de vacaciones " + $("#anio").val() + ", porfavor genere las licencias nuevamente");
                }else{
                    //Se determinan los parametros de las liquidaciones para el pedido de vacaciones
                    var fechaDesde = new Date($("#desde").val().split('-').join(','));
                    var fechaHasta = new Date($("#hasta").val().split('-').join(','));
                    var aLiquidar = new Array();
                    var refMes = fechaDesde.getMonth();
                    var diasLiquidar = 0;
                    
                    //Se recorre el rango de fechas para determinar la cantidad de dias por mes para las liquidaciones
                    for (var i = 0; i < $("#dias").val(); i++) {
                        if (refMes == fechaDesde.getMonth()) {
                            diasLiquidar ++;
                            fechaDesde.setDate(fechaDesde.getDate()+1);
                        } else{
                            aLiquidar.push({mes: refMes, dias: diasLiquidar});
                            refMes = fechaDesde.getMonth();
                            diasLiquidar = 1;
                            fechaDesde.setDate(fechaDesde.getDate()+1);
                        }
                        if (i == ($("#dias").val()-1)) {
                            aLiquidar.push({mes: refMes, dias: diasLiquidar});
                        }
                    }
                    
                    //Una vez encontrada la licencia correspondiente, se devuelven los dias correspondientes
                    if (idlv != null || d != null || p != null) {
                        //Si los parametros no son nulos se devolveran los dias correspondientes, caso contrario solo se modificara solo se modificara el pedido de vacaciones
                        url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=LicenciaVacaciones";
                        datosEnviar = ({idlicenciavacaciones: idlv, dias: d, pendiente: p});
                        $.ajax({
                            url: url,
                            method: 'POST',
                            dataType: 'json',
                            data: datosEnviar,
                            success: function(data){
                                var pendiente = p - $("#dias").val();
                                if(pendiente >= 0){
                                    //Si no se exeden los dias se procede a modificar el pedido de vacaciones
                                    url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=PedidoVacaciones";
                                    datosEnviar = ({desde: $("#desde").val(), hasta: $("#hasta").val(), cantidaddias: $("#dias").val(), idpedidovacaciones: $("#idpedidovacaciones").val(), idlicenciavacaciones: $("#idlicenciavacaciones").val(), anio:$("#anio").val(), dias: licencia.dias, pendientes: pendiente});
                                    $.ajax({
                                        url: url,
                                        method: 'POST',
                                        dataType: 'json',
                                        data: datosEnviar,
                                        success: function(data){
                                            //Se buscaran las liquidaciones del pedido de vacaciones a modificar
                                            url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=LiquidacionPedidoVacaciones";
                                            datosEnviar = ({idpedidovacaciones: $("#idpedidovacaciones").val()});
                                            $.ajax({
                                                url: url,
                                                method: 'POST',
                                                dataType: 'json',
                                                data: datosEnviar,
                                                success: function(liquidaciones){
                                                    //Se comparan las liquidaciones del pedido de vacaciones contra las liquidaciones resultado del rango de fechas
                                                    //Se va a recorrer la de mayor tamaño, dependiendo de cual sea se va a eliminar o agregar
                                                    if (liquidaciones > aLiquidar) {
                                                        $.each(liquidaciones, function(key, registro){
                                                            if(key < aLiquidar.length){
                                                                app.modificarLiquidacion(aLiquidar[key]['mes'], aLiquidar[key]['dias'], registro.id);
                                                            } else{
                                                                app.eliminarLiquidacion('LiquidacionPedidoVacaciones', registro.id);
                                                            }
                                                        });
                                                    } else{
                                                        $.each(aLiquidar, function(key, registro){
                                                            if (key < liquidaciones.length) {
                                                                app.modificarLiquidacion(registro.mes, registro.dias, liquidaciones[key]['id']);
                                                            } else{
                                                                app.agregarLiquidacion('LiquidacionPedidoVacaciones', registro.mes, registro.dias, $("#idpedidovacaciones").val());
                                                            }
                                                        });    
                                                    }
                                                        
                                                    app.actualizarDataTable("PedidoVacaciones");
                                                    $("#modalModificarPedidoVacaciones").modal('hide');
                                                    app.limpiarModal("modificar");
                                                },
                                                error: function(){
                                                    alert("Error al buscar las liquidaciones");
                                                }
                                            });
                                        },
                                        error: function(data){
                                            alert("Error al modificar el pedido de vacaciones");
                                        }
                                    });
                                }else{
                                    alert("Se exeden los dias pendientes");
                                }
                            },
                            error: function(data){
                                console.log("Error al devolver los dias a la licencia");
                            }
                        });
                    } else{
                        //Cuando se encuentra la licencia del empleado se verifica que los dias pendientes no sean exedidos por los del pedido de vacaciones
                        var pendientes = licencia.pendientes - $("#dias").val();
                        if(pendientes >= 0){
                            //Si no se exeden los dias se procede a modificar el pedido de vacaciones
                            url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=PedidoVacaciones";
                            datosEnviar = ({desde: $("#desde").val(), hasta: $("#hasta").val(), cantidaddias: $("#dias").val(), idpedidovacaciones: $("#idpedidovacaciones").val(), idlicenciavacaciones: $("#idlicenciavacaciones").val(), anio:$("#anio").val(), dias: licencia.dias, pendientes: pendientes});
                            $.ajax({
                                url: url,
                                method: 'POST',
                                dataType: 'json',
                                data: datosEnviar,
                                success: function(data){
                                    //Se agregan la o las liquidaciones, segun corresponda al rango de fechas
                                    $.each(aLiquidar, function(key, registro){
                                        app.agregarLiquidacion('LiquidacionPedidoVacaciones', registro.mes, registro.dias, $("#idpedidovacaciones").val());
                                    });
                                    //alert("Se modifico el pedido de vacaciones correctamente");
                                    app.actualizarDataTable("PedidoVacaciones");
                                    $("#modalModificarPedidoVacaciones").modal('hide');
                                    app.limpiarModal("modificar");
                                    
                                },
                                error: function(data){
                                    alert("Error al modificar el pedido de vacaciones");
                                }
                            });
                        }else{
                            alert("Se exeden los dias pendientes");
                        }
                    }
                }
            },
            error: function(data){
                alert("Error al buscar la licencia de vacaciones del empleado");
            }
        });
    };

    app.eliminarPedidoVacaciones = function(idpedidovacaciones){
        //Se eliminara solo los pedidos vacaciones que no hayan sido modificados
        var url = "../controlador/ruteador/Ruteador.php?accion=eliminar&Formulario=PedidoVacaciones";
        var datosEnviar = ({idpedidovacaciones: idpedidovacaciones});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                alert("Se elimino el pedido de vacaciones Nº " + idpedidovacaciones);
                app.actualizarDataTable("PedidoVacaciones");
            },
            error: function(data){
                alert("Error al eliminar el pedido de vacaciones");
            }
        });
    };

    // FUNCIONES LIQUIDACION

    app.agregarLiquidacion = function(controlador, mes, dias, idpedido){
        var url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=" + controlador;
        var datosEnviar = ({mes: mes, dias: parseInt(dias), idpedidovacaciones: idpedido, iddiasctalicencia: idpedido});
        console.log(datosEnviar);
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                console.log(data);
            },
            error: function(data){
                console.log(data);
                alert("Error al agregar la liquidacion de ese pedido de vacaciones");
            }
        }); 
    };

    app.buscarLiquidaciones = function(idpedidovacaciones){
        //Se buscaran el o las liquidaciones correspondientes al pedido de vacaciones
        var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Liquidacion";
        var datosEnviar = ({idpedidovacaciones: idpedidovacaciones});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                var arrayLiquidaciones = new Array();
                $.each(data, function(key, registro){
                    console.log(registro.idpedidovacaciones);
                    arrayLiquidaciones.push(({idpedidovacaciones: registro.idpedidovacaciones, mes: registro.mes, dias: registro.dias, id: registro.id, apellido: registro.apellido, nombre: registro.nombre}));
                });
                console.log(arrayLiquidaciones);
                return arrayLiquidaciones;
            },
            error: function(){
                alert("Error al buscar las liquidaciones");
            }
        });
    };

    app.modificarLiquidacion = function(mes, dias, idliquidacion){
        //Primero se buscaran las liquidaciones del pedido de vacaciones que se quiere modificar
        var url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=Liquidacion";
        var datosEnviar = ({mes: mes, dias: dias, id: idliquidacion});
        console.log(datosEnviar);
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                //console.log(data);
            },
            error: function(){
                alert("Error al modificar la liquidacion");
            }
        });
    };

    app.modificarEstadoLiquidacion = function(idliquidacion){
        var url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=Liquidacion";
        var datosEnviar = ({id: idliquidacion});
        console.log(datosEnviar);
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                //console.log(data);
                app.actualizarDataTable("Liquidaciones");
            },
            error: function(){
                alert("Error al modificar el estado de la liquidacion");
            }
        });
    };

    app.eliminarLiquidacion = function(controlador, idliquidacion){
        var url = "../controlador/ruteador/Ruteador.php?accion=eliminar&Formulario=" + controlador;
        var datosEnviar = ({idliquidacion: idliquidacion});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                //console.log(data);
            },
            error: function(){
                alert("Error al eliminar la liquidacion");
            }
        });
    }

    // FUNCIONES DIASCTALICENCIA

    app.guardarDiasCtaLicencia = function(){
        //Antes de agregar el pedido vacaciones se busca la licencia del empleado
        var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=LicenciaVacaciones";
        var datosEnviar = ({legajo: $("#legajoadc").val(), anio: $("#licencia").val()});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                if(data == false){
                    alert("Ese empleado no tiene una licencia de vacaciones, porfavor genere las licencias nuevamente");
                }else if(data.pendientes > 0){
                    //Si se encuentra la licencia y aun tiene dias pendientes se agrega el nuevo pedido
                    var url = "../controlador/ruteador/Ruteador.php?accion=agregar&Formulario=DiasCtaLicencia";
                    var datosEnviar = $("#formAgregarDiasCtaLicencia").serialize();
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: datosEnviar,
                        success: function(data){
                            //alert("Se agrego el pedido de días a cuenta de licencia correctamente");
                            //Una vez ingresado el pedido de vacaciones se genera el pdf
                            $("#formulariodiasctalicencia").val('pedido');
                            $("#iddc").val(data[0].iddiasctalicencia);
                            var f = (data[0].fecha).replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            $("#f").val(f);
                            $("#leg").val(data[0].legajo);
                            $("#ap").val(data[0].apellido);
                            $("#nom").val(data[0].nombre);
                            var ingreso = (data[0].ingreso).replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                            $("#ing").val(ingreso);
                            $("#d").val(data[0].dias);
                            $("#a").val(data[0].anio);
                            $("#imprimir").submit();

                            app.actualizarDataTable("DiasCtaLicencia");
                            $("#modalAgregarDiasCtaLicencia").modal('hide');
                        },
                        error: function(data){
                            alert("Error al agregar el pedido de dias a cuenta de licencia");
                        }
                    });
                }else{
                    alert("Al empleado no le quedan dias pendientes para esa licencia");
                }
            },
            error: function(data){
                alert("Error al buscar la licencia");
            }
        });        
    };

    app.modificarDiasCtaLicencia = function(idlv = null, d = null, p = null){
        //Antes de modificar el pedido de vacaciones se buscara la licencia del empleado del año correspondiente para asegurarse de que no se exedan los dias de vacaciones
        var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=LicenciaVacaciones";
        var datosEnviar = ({legajo: $("#legajo").val(), anio: $("#anio").val()});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(licencia){
                if(licencia == false){
                    alert("Ese empleado no tiene una licencia de vacaciones " + $("#anio").val() + ", porfavor genere las licencias nuevamente");
                }else{
                    //Se determinan los parametros de las liquidaciones para el pedido de vacaciones
                    var fechaDesde = new Date($("#desde").val().split('-').join(','));
                    var fechaHasta = new Date($("#hasta").val().split('-').join(','));
                    var aLiquidar = new Array();
                    var refMes = fechaDesde.getMonth();
                    var diasLiquidar = 0;

                    //Se recorre el rango de fechas para determinar la cantidad de dias por mes para las liquidaciones
                    for (var i = 0; i < $("#dias").val(); i++) {
                        if (refMes == fechaDesde.getMonth()) {
                            diasLiquidar ++;
                            fechaDesde.setDate(fechaDesde.getDate()+1);
                        } else{
                            aLiquidar.push({mes: refMes, dias: diasLiquidar});
                            refMes = fechaDesde.getMonth();
                            diasLiquidar = 1;
                            fechaDesde.setDate(fechaDesde.getDate()+1);
                        }
                        if (i == ($("#dias").val()-1)) {
                            aLiquidar.push({mes: refMes, dias: diasLiquidar});
                        }
                    }

                    //Una vez encontrada la licencia correspondiente, se devuelven los dias correspondientes
                    if (idlv != null || d != null || p != null) {
                        //Si los parametros no son nulos se devolveran los dias correspondientes, caso contrario solo se modificara solo se modificara el dia a cta de licencia
                        url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=LicenciaVacaciones";
                        datosEnviar = ({idlicenciavacaciones: idlv, dias: d, pendiente: p});
                        $.ajax({
                            url: url,
                            method: 'POST',
                            dataType: 'json',
                            data: datosEnviar,
                            success: function(data){
                                var pendiente = p - $("#dias").val();
                                if(pendiente >= 0){
                                    //Si no se exeden los dias se procede a modificar el pedido de vacaciones
                                    url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=DiasCtaLicencia";
                                    datosEnviar = ({desde: $("#desde").val(), hasta: $("#hasta").val(), cantidaddias: $("#dias").val(), iddiasctalicencia: $("#iddiasctalicencia").val(), idlicenciavacaciones: $("#idlicenciavacaciones").val(), anio:$("#anio").val(), dias: licencia.dias, pendientes: pendiente});
                                    $.ajax({
                                        url: url,
                                        method: 'POST',
                                        dataType: 'json',
                                        data: datosEnviar,
                                        success: function(data){
                                            //Se buscaran las liquidaciones del del dia a cuenta de licencia a modificar
                                            url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=LiquidacionDiasCtaLicencia";
                                            datosEnviar = ({iddiasctalicencia: $("#iddiasctalicencia").val()});
                                            $.ajax({
                                                url: url,
                                                method: 'POST',
                                                dataType: 'json',
                                                data: datosEnviar,
                                                success: function(liquidaciones){
                                                    //Se comparan las liquidaciones del pedido de vacaciones contra las liquidaciones resultado del rango de fechas
                                                    //Se va a recorrer la de mayor tamaño, dependiendo de cual sea se va a eliminar o agregar
                                                    if (liquidaciones > aLiquidar) {
                                                        $.each(liquidaciones, function(key, registro){
                                                            if(key < aLiquidar.length){
                                                                app.modificarLiquidacion(aLiquidar[key]['mes'], aLiquidar[key]['dias'], registro.id);
                                                            } else{
                                                                app.eliminarLiquidacion('LiquidacionDiasCtaLicencia', registro.id);
                                                            }
                                                        });
                                                    } else{
                                                        $.each(aLiquidar, function(key, registro){
                                                            if (key < liquidaciones.length) {
                                                                app.modificarLiquidacion(registro.mes, registro.dias, liquidaciones[key]['id']);
                                                            } else{
                                                                app.agregarLiquidacion('LiquidacionDiasCtaLicencia', registro.mes, registro.dias, $("#idpedidovacaciones").val());
                                                            }
                                                        });    
                                                    }
                                                },
                                                error: function(){
                                                    alert("Error al buscar las liquidaciones");
                                                }
                                            });
                                            //alert("Se modifico el día a cuenta de licencia correctamente");
                                            app.actualizarDataTable("DiasCtaLicencia");
                                            $("#modalModificarDiasCtaLicencia").modal('hide');
                                            app.limpiarModal("modificar");
                                        },
                                        error: function(data){
                                            alert("Error al modificar el día a cuenta de licencia");
                                        }
                                    });
                                }else{
                                    alert("Se exeden los días pendientes");
                                }
                            },
                            error: function(data){
                                console.log("Error al devolver los días a la licencia");
                            }
                        });
                    } else{
                        //Cuando se encuentra la licencia del empleado se verifica que los dias pendientes no sean exedidos por los del pedido de vacaciones
                        var pendientes = licencia.pendientes - $("#dias").val();
                        if(pendientes >= 0){
                            //Si no se exeden los dias se procede a modificar el pedido de vacaciones
                            url = "../controlador/ruteador/Ruteador.php?accion=modificar&Formulario=DiasCtaLicencia";
                            datosEnviar = ({desde: $("#desde").val(), hasta: $("#hasta").val(), cantidaddias: $("#dias").val(), iddiasctalicencia: $("#iddiasctalicencia").val(), idlicenciavacaciones: $("#idlicenciavacaciones").val(), anio:$("#anio").val(), dias: licencia.dias, pendientes: pendientes});
                            $.ajax({
                                url: url,
                                method: 'POST',
                                dataType: 'json',
                                data: datosEnviar,
                                success: function(data){
                                    //Se agregan la o las liquidaciones, segun corresponda al rango de fechas
                                    $.each(aLiquidar, function(key, registro){
                                        app.agregarLiquidacion('LiquidacionDiasCtaLicencia', registro.mes, registro.dias, $("#iddiasctalicencia").val());
                                    });
                                    //alert("Se modifico el día a cuenta de licencia correctamente");
                                    app.actualizarDataTable("DiasCtaLicencia");
                                    $("#modalModificarDiasCtaLicencia").modal('hide');
                                    app.limpiarModal("modificar");
                                },
                                error: function(data){
                                    alert("Error al modificar el dia a cuenta de licencia");
                                }
                            });
                        }else{
                            alert("Se exeden los días pendientes");
                        }
                    }
                }
            },
            error: function(data){
                alert("Error al buscar la licecnia de vacaciones del empleado");
            }
        });
    };

    app.eliminarDiasCtaLicencia = function(iddiasctalicencia){
        //Se eliminara solo los pedidos vacaciones que no hayan sido modificados
        var url = "../controlador/ruteador/Ruteador.php?accion=eliminar&Formulario=DiasCtaLicencia";
        var datosEnviar = ({iddiasctalicencia: iddiasctalicencia});
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: datosEnviar,
            success: function(data){
                alert("Se elimino el pedido de dias a cuenta de licencia Nº " + iddiasctalicencia);
                app.actualizarDataTable("DiasCtaLicencia");
            },
            error: function(data){
                alert("Error al eliminar el pedido de dias a cuenta de licencia");
            }
        });
    };

    app.oyentes = function(tipo){

    	//Se almacenan los datos de la tabla en una variable para utilizar sus metodos
        var tabla = $("#tabla" + tipo).DataTable();

        //Variable utilizada para guardar los datos de la fila seleccionada
        var fila = null;

        //Se cargan los datos de la fila seleccionada para acceder a cada uno de ellos
        $("#tabla" + tipo + " tbody").on('click', 'tr', function(){
            fila = tabla.row(this).data();
        });

        // BOTONES LICENCIA VACACIONES

        $("#agregarLicenciaVacaciones").on('click', function(){
            app.limpiarModal("agregar");
            $("#formAgregarLicenciaVacaciones").data('bootstrapValidator').resetForm();
            $("#modalAgregarLicenciaVacaciones").modal('show');
            app.autocompletar("legajoapv", "apellidoapv", "nombreapv");
            app.listarLicencias("licencia");
        });

        $("#generarLicenciasVacaciones").on('click', function(){
            //Se generan las licencias del año corriente para los empleados, controlando de que no se repitan, ya que cada empleado solo puede tener una licencia por año
            app.generarLicencias();
        });

        $("#modificarLicenciaVacaciones").on('click', function(){
            app.limpiarModal("modificar");
            $("#formModificarLicenciaVacaciones").data('bootstrapValidator').resetForm();
            if(fila != null){
                $("#idlicenciavacaciones").val(fila['id']);
                $("#legajomlv").val(fila['legajo']);
                $("#apellidomlv").val(fila['apellido']);
                $("#nombremlv").val(fila['nombre']);
                $("#licenciamlv").val(fila['anio']);
                $("#diasmlv").val(fila['dias']);
                $("#pendientesmlv").val(fila['pendientes']);
                $("#modalModificarLicenciaVacaciones").modal('show');
            }else{
                alert("Primero debe seleccionar una licencia de vacaciones");
            }
        });

        $("#imprimirLicenciaVacaciones").on('click', function(){
            
        });

        // BOTONES PEDIDO VACACIONES

        $("#generarPedidoVacaciones").on('click', function(){
            $("#formGenerarPedidoVacaciones").data('bootstrapValidator').resetForm();
            $("#seccion").empty();
            app.listarSecciones();
            app.listarLicencias("licenciagpv");
            var f = new Date();
            var dia = ("0" + f.getDate()).slice(-2);
            var mes = ("0" + (f.getMonth() + 1)).slice(-2);
            var hoy = f.getFullYear()+"-"+(mes)+"-"+(dia);
            $('#fechagpv').val(hoy);
            $("#modalGenerarPedidoVacaciones").modal({show: true});
        });

        $("#agregarPedidoVacaciones").on('click', function(){

        	app.limpiarModal("agregar");
            $("#formAgregarPedidoVacaciones").data('bootstrapValidator').resetForm();
        	app.listarLicencias("licencia");
            app.autocompletar("legajoapv", "apellidoapv", "nombreapv");
            var f = new Date();
            var dia = ("0" + f.getDate()).slice(-2);
            var mes = ("0" + (f.getMonth() + 1)).slice(-2);
            var hoy = f.getFullYear()+"-"+(mes)+"-"+(dia);
            $('#fechaapv').val(hoy);
            $('#modalAgregarPedidoVacaciones').on('shown.bs.modal', function () {
              $('#legajoapv').trigger('focus')
            })
			$("#modalAgregarPedidoVacaciones").modal({show: true});
        });

        $("#modificarPedidoVacaciones").on('click', function(){
            var fecha = new Date();
            $("#formModificarPedidoVacaciones").data('bootstrapValidator').resetForm();
            if(fila == null) {
                alert("Debes seleccionar un pedido de vacaciones");
            } else{
                var desde = new Date(fila['desde']);
                var hasta = new Date(fila['hasta']);
                if(desde > fecha && hasta > fecha || fila['desde'] == null || fila['hasta'] == null){
                    app.limpiarModal("modificar");
                    $("#idpedidovacaciones").val(fila['id']);
                    $("#fecha").val(fila['fecha']);        
                    $("#legajo").val(fila['legajo']);
                    $("#apellido").val(fila['apellido']);
                    $("#nombre").val(fila['nombre']);
                    $("#idlicenciavacaciones").val(fila['idlicenciavacaciones']);
                    $("#anio").val(fila['anio']);
                    app.calcularDias();
                    $("#modalModificarPedidoVacaciones").modal({show: true});
                } else{
                    alert("Ese pedido ya ha sido tomado");
                }
            }
        });

        $("#eliminarPedidoVacaciones").on('click', function(){
            if(fila == null){
                alert("Debes seleccionar un pedido de vacaciones");
            }else{
                if(fila['desde'] == null && fila['hasta'] == null){
                    if(confirm("¿Desea eliminar el pedido de vacaciones?")){
                        app.eliminarPedidoVacaciones(fila['id']);
                        fila = null;
                    }
                }else{
                    alert("No se puede eliminar ese pedido de vacaciones");
                }
            }
        });

        $("#imprimirPedidoVacaciones").on('click', function(){
            if (fila['hasta'] != null && fila['hasta'] != null){
                $("#formulariopedidovacaciones").val('completo');
                var d = fila['desde'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                $("#des").val(d);
                var a = fila['hasta'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                $("#has").val(a);
            }else{
                $("#formulariopedidovacaciones").val('pedido');
            }
            $("#idpv").val(fila['id']);
            var fecha = fila['fecha'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
            $("#f").val(fecha);
            $("#leg").val(fila['legajo']);
            $("#ap").val(fila['apellido']);
            $("#nom").val(fila['nombre']);
            var ingreso = fila['ingreso'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
            $("#ing").val(ingreso);
            $("#d").val(fila['dias']);
            $("#a").val(fila['anio']);
            $("#p").val(fila['pendientes']);
            $("#cd").val(fila['cantidaddias']);
            $("#imprimir").submit();
        });

        // BOTONES DIASCTALICENCIA

        $("#agregarDiasCtaLicencia").on('click', function(){
            app.limpiarModal("agregardc");
            $("#formAgregarDiasCtaLicencia").data('bootstrapValidator').resetForm();
            app.listarLicencias("licencia");
            app.autocompletar("legajoadc", "apellidoadc", "nombreadc");
            var f = new Date();
            var dia = ("0" + f.getDate()).slice(-2);
            var mes = ("0" + (f.getMonth() + 1)).slice(-2);
            var hoy = f.getFullYear()+"-"+(mes)+"-"+(dia);
            $('#fechaadc').val(hoy);
            $("#modalAgregarDiasCtaLicencia").modal({show: true});
        });

        $("#modificarDiasCtaLicencia").on('click', function(){
            var fecha = new Date();
            $("#formModificarDiasCtaLicencia").data('bootstrapValidator').resetForm();
            app.limpiarModal("modificardc");
            if(fila == null) {
                alert("Debes seleccionar un pedido de vacaciones");
            } else{
                var desde = new Date(fila['desde']);
                var hasta = new Date(fila['hasta']);
                if(desde > fecha && hasta > fecha || fila['desde'] == null || fila['hasta'] == null){
                    app.limpiarModal("modificar");
                    $("#iddiasctalicencia").val(fila['id']);
                    $("#fecha").val(fila['fecha']);        
                    $("#legajo").val(fila['legajo']);
                    $("#apellido").val(fila['apellido']);
                    $("#nombre").val(fila['nombre']);
                    $("#idlicenciavacaciones").val(fila['idlicenciavacaciones']);
                    $("#anio").val(fila['anio']);
                    app.calcularDias();
                    $("#modalModificarDiasCtaLicencia").modal({show: true});
                } else{
                    alert("Ese pedido ya ha sido tomado");
                }
            }
        });

        $("#eliminarDiasCtaLicencia").on('click', function(){
            if(fila == null){
                alert("Debes seleccionar un pedido de vacaciones");
            }else{
                if(fila['desde'] == null && fila['hasta'] == null){
                    if(confirm("¿Desea eliminar el pedido de dias a cuenta de licencia?")){
                        app.eliminarDiasCtaLicencia(fila['id']);
                        fila = null;
                    }
                }else{
                    alert("No se puede eliminar ese pedido de dias a cuenta de licencia");
                }
            }
        });

        $("#imprimirDiasCtaLicencia").on('click', function(){
            if (fila['hasta'] != null && fila['hasta'] != null){
                $("#formulariodiasctalicencia").val('completo');
                var d = fila['desde'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                $("#des").val(d);
                var a = fila['hasta'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                $("#has").val(a);
            }else{
                $("#formulariodiasctalicencia").val('pedido');
            }
            $("#iddc").val(fila['id']);
            var fecha = fila['fecha'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
            $("#f").val(fecha);
            $("#leg").val(fila['legajo']);
            $("#ap").val(fila['apellido']);
            $("#nom").val(fila['nombre']);
            var ingreso = fila['ingreso'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
            $("#ing").val(ingreso);
            $("#d").val(fila['dias']);
            $("#a").val(fila['anio']);
            $("#p").val(fila['pendientes']);
            $("#cd").val(fila['cantidaddias']);
            $("#imprimir").submit();
        });

        // BOTONES LIQUIDACION

        $("#modificarLiquidacion").on('click', function(){
            console.log(fila);
            if (fila != null) {
                if (confirm("¿Esta seguro de modificar la liquidacion de vacaciones?")) {
                    app.modificarEstadoLiquidacion(fila['id']);
                }
            } else{
                alert("Primero seleccione una liquidacion de vacaciones");
            }
        });

        $("#imprimirLiquidacion").on('click', function(){
            //Se guardan todas las filas filtradas por la busqueda para ser impresas
            var filas = tabla.rows({filter: 'applied'}).data().toArray();
            var liquidaciones = JSON.stringify(filas);
            $("#arrayLiquidaciones").val(liquidaciones);
            $("#imprimir").submit();

        });

        // BOTONES AUDITORIA

        $("#AuditoriaPedidoVacaciones").on('click', function(){
            if (fila != null) {
                var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Auditoria";
                var datosEnviar = ({tabla: "pedidovacaciones", idregistro: fila['id']});
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: datosEnviar,
                    success: function(data){
                        app.cargarAuditoria(data);
                        $("#modalAuditoriaPedidoVacaciones").modal({show: true});
                    },
                    error: function(data){
                        alert("Error al cargar los datos de auditoria");
                    }
                });
            }else{
                alert("Debe seleccionar un pedido de vacaciones");
            }  
        });

        $("#AuditoriaDiasCtaLicencia").on('click', function(){
            if (fila != null) {
                var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Auditoria";
                var datosEnviar = ({tabla: "diasctalicencia", idregistro: fila['id']});
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: datosEnviar,
                    success: function(data){
                        app.cargarAuditoria(data);
                        $("#modalAuditoriaDiasCtaLicencia").modal({show: true});
                    },
                    error: function(data){
                        alert("Error al cargar los datos de auditoria");
                    }
                });
            }else{
                alert("Debe seleccionar un dia a cuenta de licencia");
            }  
        });

        $("#AuditoriaLicenciaVacaciones").on('click', function(){
            if (fila != null) {
                var url = "../controlador/ruteador/Ruteador.php?accion=buscar&Formulario=Auditoria";
                var datosEnviar = ({tabla: "licenciavacaciones", idregistro: fila['id']});
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: datosEnviar,
                    success: function(data){
                        app.cargarAuditoria(data);
                        $("#modalAuditoriaLicenciaVacaciones").modal({show: true});
                    },
                    error: function(data){
                        alert("Error al cargar los datos de auditoria");
                    }
                });
            }else{
                alert("Debe seleccionar una licencia de vacaciones");
            }  
        });

        // FORMULARIOS LICENCIA VACACIONES

        $("#formAgregarLicenciaVacaciones").bootstrapValidator({
            excluded: []
        })
            .on('error.form.bv', function(e){
                alert("Debe completar los campos requeridos");
            })
            .on('success.form.bv', function(e){
                e.preventDefault();
                app.agregarLicenciaVacaciones();
        });

        $("#formModificarLicenciaVacaciones").bootstrapValidator({
            excluded: []
        })
            .on('error.form.bv', function(e){
                alert("Debe completar los campos requeridos");
            })
            .on('success.form.bv', function(e){
                e.preventDefault();
                var pendientes = parseInt($("#diasmlv").val()) - (parseInt(fila['dias']) - parseInt(fila['pendientes']));
                if(pendientes >= 0){
                    app.modificarLicencia($("#idlicenciavacaciones").val(), $("#diasmlv").val(), pendientes);
                    app.actualizarDataTable("LicenciaVacaciones");
                    $("#modalModificarLicenciaVacaciones").modal('hide');
                    fila = null;
                }else{
                    alert("Se exceden los días tomados para esa licencia");
                }
                

        });

        // FORMULARIOS PEDIDO VACACIONES

        //Se configuran las validaciones de bootstrap para el formulario de agregar pedido vacaciones
        $("#formAgregarPedidoVacaciones").bootstrapValidator({
            excluded: []
        })
            .on('error.form.bv', function(e){
                alert("Debe completar los campos requeridos");
            })
            .on('success.form.bv', function(e){
                e.preventDefault();
                app.guardarPedidoVacaciones();
        });

        $("#formGenerarPedidoVacaciones").bootstrapValidator({
            excluded: []
        })
            .on('error.form.bv', function(e){
                alert("Debe seleccionar una delegación");
            })
            .on('success.form.bv', function(e){
                //e.preventDefault();
                app.actualizarDataTable("PedidoVacaciones");
                $("#modalGenerarPedidoVacaciones").modal('hide');
        });

        //Se configuran las validaciones de bootstrap para el formulario de modificar pedido vacaciones
        $("#formModificarPedidoVacaciones").bootstrapValidator({
            excluded: []
        })
            .on('error.form.bv', function(e){
                alert("Debe completar los campos requeridos");
            })
            .on('success.form.bv', function(e){
                e.preventDefault();
                if(fila['pendientes'] != null){
                    //En caso de querer modificar la cantidad de dias de un pedido de vacaciones, se devolveran los dias ya establecidos a la correspondiente licencia
                    var dias = parseInt(fila['cantidaddias'], 10) + parseInt(fila['pendientes'], 10);
                    app.modificarPedidoVacaciones(fila['idlicenciavacaciones'], fila['dias'], dias);
                } else{
                    app.modificarPedidoVacaciones();
                }
                fila = null;
        });

        // FORMULARIOS DIASCTALICENCIA

        $("#formAgregarDiasCtaLicencia").bootstrapValidator({
            excluded: []
        })
            .on('error.form.bv', function(e){
                alert("Debe completar los campos requeridos");
            })
            .on('success.form.bv', function(e){
                e.preventDefault();
                app.guardarDiasCtaLicencia();
        });

        $("#formModificarDiasCtaLicencia").bootstrapValidator({
            excluded: []
        })
            .on('error.form.bv', function(e){
                alert("Debe completar los campos requeridos");
            })
            .on('success.form.bv', function(e){
                e.preventDefault();
                
                //En caso de que la cantidad de dias sea menor a 7 dias, se lo considera como dias pendientes, y por lo tanto si dentro del rango es dia lunes o viernes se le hara saber al usuario para que decida si sumarle los dias sabado y domingo
                if($("#dias").val() < 7){
                    var desde = new Date($("#desde").val()),
                        hasta = new Date($("#hasta").val()),
                        condicion = null;
                    //Se controla si la fecha de inicio corresponde al dia lunes
                    if(desde.getDay() == 0){
                        if(confirm("La fecha de inicio corresponde a dia Lunes ¿Desea incorporar los dias Sabado y Domingo correspondientes?")){
                            condicion = true;
                        }else{
                            condicion = false;
                        }
                    }

                    //Se controla si la fecha de inicio corresponde al dia viernes
                    else if(desde.getDay() == 4){
                        if(confirm("La fecha de inicio corresponde a dia Viernes ¿Desea incorporar los dias Sabado y Domingo correspondientes?")){
                            condicion = true;
                        }else{
                            condicion = false;
                        }
                    }

                    //Se controla si la fecha de finalizacion corresponde al dia lunes
                    else if(hasta.getDay() == 0){
                        if(confirm("La fecha de finalizacion corresponde a dia Lunes ¿Desea incorporar los dias Sabado y Domingo correspondientes?")){
                            condicion = true;
                        }else{
                            condicion = false;
                        }
                    }

                    //Se controla si la fecha de finalizacion corresponde al dia viernes
                    else if(hasta.getDay() == 4){
                        if(confirm("La fecha de finalizacion corresponde a dia Viernes ¿Desea incorporar los dias Sabado y Domingo correspondientes?")){
                            condicion = true;
                        }else{
                            condicion = false;
                        }
                    }

                    if(condicion == true){
                        if(fila['pendientes'] != null){
                            //En caso de querer modificar la cantidad de dias de un pedido de vacaciones, se devolveran los dias ya establecidos a la correspondiente licencia
                            var dias = parseInt(fila['cantidaddias'], 10) + parseInt(fila['pendientes'], 10);
                            $("#dias").val(parseInt($("#dias").val(), 10) + 2);
                            app.modificarDiasCtaLicencia(fila['idlicenciavacaciones'], fila['dias'], dias);
                            fila = null;
                        }else{
                            $("#dias").val(parseInt($("#dias").val(), 10) + 2);
                            app.modificarDiasCtaLicencia();
                            fila = null;    
                        }
                        
                    }else{
                        if(fila['pendientes'] != null){
                            //En caso de querer modificar la cantidad de dias de un pedido de vacaciones, se devolveran los dias ya establecidos a la correspondiente licencia
                            var dias = parseInt(fila['cantidaddias'], 10) + parseInt(fila['pendientes'], 10);
                            app.modificarDiasCtaLicencia(fila['idlicenciavacaciones'], fila['dias'], dias);
                            fila = null;
                        }else{
                            app.modificarDiasCtaLicencia();
                            fila = null;    
                        }
                    }
                }else{
                    //Si la cantidad de dias es de 7 o mas dias se trata de un pedido de vacaciones
                    alert("Los días solicitados son superior a 7 días, porfavor realice la carga de un pedido de vacaciones");
                }
        });

    };//FIN DE OYENTES 

};