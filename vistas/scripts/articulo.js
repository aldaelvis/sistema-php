var tabla;

function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function(e)
    {
        guardaryeditar(e);
    });
    $.post("../ajax/articulo.php?op=selectCategoria", function(r){
        $("#idcategoria").html(r);
        $("#idcategoria").selectpicker('refresh');
    });
    $('#imagenmuestra').hide();
}

function limpiar(){
    $("#idarticulo").val("");
    $("#codigo").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#stock").val("");
    $("#imagenmuestra").attr('src',"");
    $("#imagenactual").val("");
    $("#print").hide();
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
                    url: '../ajax/articulo.php?op=listar',
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
        url: '../ajax/articulo.php?op=guardaryeditar',
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
function mostrar(idarticulo){
    $.post("../ajax/articulo.php?op=mostrar",
        { idarticulo : idarticulo },
        function (data, status) {
         data = JSON.parse(data);
         mostrarform(true);

         $("#idcategoria").val(data.idcategoria);
         $('#idcategoria').selectpicker('refresh');
         $("#codigo").val(data.codigo);
         $("#nombre").val(data.nombre);
         $("#stock").val(data.stock);
         $("#descripcion").val(data.descripcion);
         $("#imagenmuestra").show();
         $("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
         $("#imagenactual").val(data.imagen);
         $("#idarticulo").val(data.idarticulo);
         generarbarcode();
        }
    );
}

function desactivar(idarticulo){
    bootbox.confirm("¿Está seguro de desactivar el artículo?", function (result) {
        if(result) {
            $.post('../ajax/articulo.php?op=desactivar',{idarticulo:idarticulo}, function (e) {
               bootbox.alert(e);
               tabla.ajax.reload();
            });
        }
    });
}

function activar(idarticulo){
    bootbox.confirm("¿Está seguro de activar el artículo?", function (result) {
        if(result) {
            $.post('../ajax/articulo.php?op=activar',{idarticulo:idarticulo}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

function generarbarcode() {
    codigo = $("#codigo").val();
    JsBarcode("#barcode" , codigo);
    $('#print').show();
}

function imprimir(){
    $("#print").printArea();
}


init();