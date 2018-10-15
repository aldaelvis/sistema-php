var tabla;

function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function(e)
    {
        guardaryeditar(e);
    });

    $.post("../ajax/venta.php?op=selectCliente" , function(r){
        $("#idpersona").html(r);
        $("#idpersona").selectpicker('refresh');
    });
    
}

function limpiar(){
    $("#idventa").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#fecha_hora").val("");
    $("#impuesto").val("");

    $("#total_venta").val("");
    $(".filas").remove();
    $("#total").html("0");

    //obtener la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day);
    $("#fecha_hora").val(today);
}

function mostrarform(flag){
    limpiar();
    if( flag ) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnguardar").prop('disabled', false);
        $("#buttonAgregar").hide();
        listarArticulos();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles = 0;
        $("#btnAgregarArt").show();

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
                    url: '../ajax/venta.php?op=listar',
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

function listarArticulos() {
    tabla = $('#tblarticulos').dataTable(
        {
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            buttons: [
            ],
            "ajax":{
                    url: '../ajax/venta.php?op=listarActivosVenta',
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

//Guardar
function guardaryeditar(e) {
    e.preventDefault();
    $('#btnGuardar').prop("disabled", false);
    var formdata = new FormData($("#formulario")[0]);

    $.ajax({
        url: '../ajax/venta.php?op=guardaryeditar',
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
function mostrar(idventa){
    $.post("../ajax/venta.php?op=mostrar",
        { idventa : idventa },
        function (data, status) {
         data = JSON.parse(data);
         mostrarform(true);

         $("#idpersona").val(data.idpersona);
         $('#idpersona').selectpicker('refresh');
         $("#tipo_comprobante").val(data.tipo_comprobante);
         $('#tipo_comprobante').selectpicker('refresh');
         $("#serie_comprobante").val(data.serie_comprobante);
         $("#num_comprobante").val(data.num_comprobante);
         $("#fecha_hora").val(data.Fecha);
         $("#impuesto").val(data.impuesto);
         $("#idventa").val(data.idventa);
         
         //ocultar y mostrarbotones
         $("#btnGuardar").hide();
         $("#btnCancelar").show();
         $("#btnAgregarArt").hide();
        }
    );

    $.post("../ajax/venta.php?op=listarDetalle&id="+idventa, function(r){
        $("#detalles").html(r);
    });
}

function anular(idventa){
    bootbox.confirm("¿Está seguro de anular la venta?", function (result) {
        if(result) {
            $.post('../ajax/venta.php?op=anular',{idventa:idventa}, function (e) {
               bootbox.alert(e);
               tabla.ajax.reload();
            });
        }
    });
}

var impuesto = 18;
var cont = 0;
var detalles = 0;
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto());

function marcarImpuesto()
{
    var tipo_comprobante = $("#tipo_comprobante option:selected").text();
    //console.log(tipo_comprobante);
    if(tipo_comprobante == 'Factura')
    {
        $("#impuesto").val(impuesto);
    }else 
    {
        $("#impuesto").val("0");
    }
}

function agregarDetalle(idarticulo, nombre, precio_venta)
{
    var cantidad = 1;
    var descuento = 0;

    if(idarticulo != "")
    {
        var subtotal = cantidad * precio_venta;
        var fila = '<tr class="filas" id="fila'+cont+'">' + 
        '<td><button class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
        '<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'" />'+nombre+'</td>'+
        '<td><input type="number" name="cantidad[]" value="'+cantidad+'" /></td>'+
        '<td><input type="number" name="precio_venta[]" value="'+precio_venta+'" /></td>'+
        '<td><input type="number" name="descuento[]" value="'+descuento+'" /></td>'+
        '<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
        '<td><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
        '</tr>';
        cont++;
        detalles++;
        $("#detalles").append(fila);
        modificarSubtotales();
    }else {
        alert("Datos incorrectos")
    }

}

function modificarSubtotales(){
    var cant = document.getElementsByName("cantidad[]");
    var prev = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]")
    var sub = document.getElementsByName("subtotal");
    for (let i = 0; i < cant.length; i++) {
        var inpC = cant[i];
        var inpV = prev[i];
        var inpD = desc[i]; 
        var inpS = sub[i];

        inpS.value = (inpC.value * inpV.value) - inpD.value;
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }

    calcularTotales();
}

function calcularTotales()
{
    var sub = document.getElementsByName("subtotal");
    var total = 0.0;

    for (let k = 0; k < sub.length; k++) {
        total += document.getElementsByName("subtotal")[k].value;
    }

    $("#total").html("S/. " + total);
    $("#total_venta").val(total);
    evaluar();
}

function evaluar()
{
    if(detalles > 0)
    {
        $("#btnGuardar").show();
    }else {
        $("#btnGuardar").hide();
        cont = 0;
    }
}

function eliminarDetalle(indice)
{
    $("#fila"+indice).remove();
    calcularTotales();
    detalles--;
}



init();