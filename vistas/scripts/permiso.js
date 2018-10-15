var tabla;

function init() {
    mostrarform(false);
    listar();
}

function mostrarform(flag){
    if( flag ) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnguardar").prop('disabled', false);
        $("#buttonAgregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#buttonAgregar").hide();
    }
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
                    url: '../ajax/permiso.php?op=listar',
                    type: 'get',
                    dataType: 'json',
                    error: function(e) {
                        console.log(e.responseText);
                    }
            },
            'bDestroy':true,
            'iDisplayLength':5, //paginación
            'order': [[0, 'asc']] //ordenar (columna, orden)
        }
    ).DataTable();
}


init();