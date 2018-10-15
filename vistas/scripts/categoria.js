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
    $("#idcategoria").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
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
                    url: '../ajax/categoria.php?op=listar',
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
        url: '../ajax/categoria.php?op=guardaryeditar',
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
function mostrar(idcategoria){
    $.post("../ajax/categoria.php?op=mostrar",
        { idcategoria : idcategoria },
        function (data, status) {
         data = JSON.parse(data);
         mostrarform(true);

         $("#nombre").val(data.nombre);
         $("#descripcion").val(data.descripcion);
         $("#idcategoria").val(data.idcategoria);
        }
    );
}

function desactivar(idcategoria){
    bootbox.confirm("¿Estas seguro de desactivar la categoría?", function (result) {
        if(result) {
            $.post('../ajax/categoria.php?op=desactivar',{idcategoria:idcategoria}, function (e) {
               bootbox.alert(e);
               tabla.ajax.reload();
            });
        }
    });
}

function activar(idcategoria){
    bootbox.confirm("¿Estas seguro de activar la categoría?", function (result) {
        if(result) {
            $.post('../ajax/categoria.php?op=activar',{idcategoria:idcategoria}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}


init();