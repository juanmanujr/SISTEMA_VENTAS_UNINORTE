function init(){
    $("#usuario_form").on("submit", function(e){
        guardaryeditar(e);
    });
}

$(document).ready(function(){
    tabla = $('#usuario_data').DataTable({
        "processing": true, 
        "serverSide": false, 
        "dom": 'Bfrtip', 
        "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
        "ajax": {
            url: '../../controller/usuario.php?op=listar',
            type: "get",
            dataType: "json",
            dataSrc: "aaData", // Para que lea el JSON del estilo del profesor
            error: function(e){
                console.log("Error en AJAX:", e);
            }
        },
        "destroy": true,
        "responsive": true,
        "info": true,
        "pageLength": 10, 
        "order": [[ 0, "asc" ]],
        "language": {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "info": "Mostrando un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando un total de 0 registros",
            "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero", "last": "Último", "next": "Siguiente", "previous": "Anterior"
            }
        }
    });
});

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#usuario_form")[0]);
    $.ajax({
        url: "../../controller/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(resp){
            let r;
            try { r = typeof resp === 'string' ? JSON.parse(resp) : resp; }
            catch(err){ r = { ok: true, msg: 'Guardado.' }; }

            if (r.ok === false) {
                Swal.fire('Atención', r.msg, 'warning');
                return;
            }

            $('#usuario_form')[0].reset();
            $("#modalmantenimiento_usuario").modal('hide');
            $('#usuario_data').DataTable().ajax.reload();

            Swal.fire('¡Listo!', r.msg, 'success');
        }
    });
}

function editar(usu_id){
    $.post("../../controller/usuario.php?op=mostrar",{usu_id:usu_id},function (data) {
        data = JSON.parse(data);
        $('#usu_id').val(data.usu_id);
        $('#usu_nom').val(data.usu_nom);
        $('#usu_sesion').val(data.usu_sesion);
        $('#usu_clave').val(''); // Clave vacía al editar
        $('#ayuda_clave').show();
    });
    $('#mdltitulo').html('Editar Registro');
    $("#modalmantenimiento_usuario").modal('show');
}

function eliminar(usu_id){
    Swal.fire({
        title: "¿Estás seguro?",
        text: "El usuario se eliminará lógicamente.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, elimínalo!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/usuario.php?op=eliminar", {usu_id: usu_id}, function(data){
                $("#usuario_data").DataTable().ajax.reload();
                Swal.fire("¡Eliminado!", "El usuario ha sido eliminado.", "success");
            });
        }
    });
}

$(document).on("click", "#btnNuevoUsuario", function(){
    $("#usuario_form")[0].reset();
    $('#usu_id').val('');
    $('#ayuda_clave').hide();
    $("#mdltitulo").text("Nuevo Registro");
    $("#modalmantenimiento_usuario").modal("show");
});

init();