function init(){
    $("#producto_form").on("submit", function(e){
        guardaryeditar(e);
    });
}

$(document).ready(function(){

    tabla = $('#producto_data').dataTable({
        "aProcessing": true, 
        // "aServerSide" se elimina para evitar conflictos con la versión moderna
        dom: 'Bfrtip', 

        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],

        "ajax": {
            url: '../../controller/producto.php?op=listar',
            type: "get",
            dataType: "json",
            dataSrc: "aaData", // <-- OBLIGATORIO: Lee la propiedad "aaData" que manda el profe
            error: function(e){
                console.log("Error en AJAX:", e.responseText);
            }
        },

        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10, 

        "order": [[ 0, "asc" ]],

        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(Filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }

    }); // <-- NO PONGAS .DataTable() ACÁ AL FINAL

});
function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#producto_form")[0]);
    $.ajax({
        url: "../../controller/producto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            $('#producto_form')[0].reset();
            $("#modalmantenimiento").modal('hide');
            $('#producto_data').DataTable().ajax.reload();

            swal.fire(
                'Registro!',
                'El registro se guardó correctamente.',
                'success'
            );
        }
    });
}


function editar(prod_id){
    $.post("../../controller/producto.php?op=mostrar",{prod_id:prod_id},function (data) {
        data = JSON.parse(data);
        $('#prod_id').val(data.prod_id);
        $('#prod_nom').val(data.prod_nom);
    });
    $('#mdltitulo').html('Editar Registro');
    $('#modalmantenimiento').modal('show');
}

function eliminar(prod_id){
    console.log("eliminar" + prod_id);
    
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, elimínalo!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/producto.php?op=eliminar", {prod_id: prod_id}, function(data){
                $("#producto_data").DataTable().ajax.reload();
            });

            Swal.fire({
                title: "¡Eliminado!",
                text: "Tu archivo ha sido eliminado.",
                icon: "success"
            });
        }
    });
}

$(document).on("click", "#btnNuevo", function(){
    $("#producto_form")[0].reset();
    $(".modal-header").css("background-color", "#28a79c");
    $(".modal-header").css("color", "white");
    $("#mdltitulo").text("Nuevo Registro");
    $("#modalmantenimiento").modal("show");
});

init();