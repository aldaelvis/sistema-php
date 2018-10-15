var table;


function init()
{
    listar();
    $("#fecha_inicio").change(listar);
    $("#fecha_fin").change(listar);
}

function listar()
{
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    table = $('#tbllistado').dataTable({
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
                url: '../ajax/consultas.php?op=listar',
                data: {fecha_inicio:fecha_inicio, fecha_fin:fecha_fin},
                type: 'get',
                dataType: 'json',
                error: function(e) {
                    console.log(e.responseText);
                }
        },
        'bDestroy':true,
        'iDisplayLength':5, //paginación
        'order': [0, 'asc'] //ordenar (columna, orden)
        }
    ).DataTable();
}

init();