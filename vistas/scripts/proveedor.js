var tabla;

function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function(e)
    {
        guardaryeditar(e);
    });
}

function limpiar(){
    $("#idpersona").val("");
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
}

function mostrarform(flag){
    limpiar();
    if( flag ) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnguardar").prop('disabled', false);
        $("#buttonAgregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#buttonAgregar").show();
    }
}

//cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//funcion listar
function listar() {
    tabla = $('#tbllistado').dataTable(
        {
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":{
                    url: '../ajax/persona.php?op=listarp',
                    type: 'get',
                    dataType: 'json',
                    error: function(e) {
                        console.log(e.responseText);
                    }
            },
            'bDestroy':true,
            'iDisplayLength':5, //paginación
            'order': [[1, 'asc']] //ordenar (columna, orden)
        }
    ).DataTable();
}

//Guardar
function guardaryeditar(e) {
    e.preventDefault();
    $('#btnGuardar').prop("disabled", false);
    var formdata = new FormData($("#formulario")[0]);

    $.ajax({
        url: '../ajax/persona.php?op=guardaryeditar',
        type: 'POST',
        data: formdata,
        contentType: false,
        processData: false,
        success: function( datos ) {
            bootbox.alert(datos);
            mostrarform();
            tabla.ajax.reload();
        }
    });
    limpiar();
}

//mostrar datos en los formulario
function mostrar(idpersona){
    $.post("../ajax/persona.php?op=mostrar",
        { idpersona : idpersona },function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);

            $("#nombre").val(data.nombre);
            $("#tipo_documento").val(data.tipo_documento);
            $("#tipo_documento").selectpicker('refresh');
            $("#num_documento").val(data.num_documento);
            $("#direccion").val(data.direccion);
            $("#telefono").val(data.telefono);
            $("#email").val(data.email);
            $("#idpersona").val(data.idpersona);
        }
    );
}

function eliminar(idpersona){
    bootbox.confirm("¿Estas seguro de eliminar el Proveedor?", function (result) {
        if(result) {
            $.post('../ajax/persona.php?op=eliminar',{ idpersona:idpersona }, function (e) {
               bootbox.alert(e);
               tabla.ajax.reload();
            });
        }
    });
}

init();