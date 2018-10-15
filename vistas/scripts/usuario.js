var tabla;

function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
    $('#imagenmuestra').hide();
    $.post("../ajax/usuario.php?op=permisos&id=", function(r){
        $("#permisos").html(r);
    });
}

function limpiar() {
    $("#idusuario").val("");
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#imagenmuestra").attr('src', "");
    $("#imagenactual").val("");
    $("#imagen").val("");
}

function mostrarform(flag) {
    limpiar();
    if (flag) {
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
            "ajax": {
                url: '../ajax/usuario.php?op=listar',
                type: 'get',
                dataType: 'json',
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            'bDestroy': true,
            'iDisplayLength': 5, //paginación
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
        url: '../ajax/usuario.php?op=guardaryeditar',
        type: 'POST',
        data: formdata,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
            mostrarform();
            tabla.ajax.reload();
        }
    });
    limpiar();
}

//mostrar datos en los formulario
function mostrar(idusuario) {
    $.post("../ajax/usuario.php?op=mostrar",
        {idusuario: idusuario}, function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);

            $("#nombre").val(data.nombre);
            $("#tipo_documento").val(data.tipo_documento);
            $("#tipo_documento").selectpicker('refresh');
            $("#num_documento").val(data.num_documento);
            $("#direccion").val(data.direccion);
            $("#telefono").val(data.telefono);
            $("#email").val(data.email);
            $("#cargo").val(data.cargo);
            $("#login").val(data.login);
            $("#clave").val(data.clave);
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
            $("#imagenactual").val(data.imagen);
            $("#idusuario").val(data.idusuario);
        }
    );
    $.post("../ajax/usuario.php?op=permisos&id="+idusuario, function(r){
        $("#permisos").html(r);
    });
}

function desactivar(idusuario) {
    bootbox.confirm("¿Está seguro de desactivar el usuario?", function (result) {
        if (result) {
            $.post('../ajax/usuario.php?op=desactivar', {idusuario: idusuario}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

function activar(idusuario) {
    bootbox.confirm("¿Está seguro de activar el usuario?", function (result) {
        if (result) {
            $.post('../ajax/usuario.php?op=activar', {idusuario: idusuario}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

init();