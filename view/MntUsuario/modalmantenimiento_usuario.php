<div id="modalmantenimiento_usuario" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="usuario_form">
                <div class="modal-header">
                    <h4 class="modal-title" id="mdltitulo"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="usu_id" name="usu_id">

                    <div class="form-group">
                        <label class="form-label" for="usu_nom">Nombre *</label>
                        <input type="text" class="form-control" id="usu_nom" name="usu_nom" placeholder="Ingrese Nombre" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_sesion">Usuario (Sesión) *</label>
                        <input type="text" class="form-control" id="usu_sesion" name="usu_sesion" placeholder="Ingrese Usuario" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_clave">Contraseña</label>
                        <input type="password" class="form-control" id="usu_clave" name="usu_clave" placeholder="Ingrese Contraseña">
                        <small class="text-muted" id="ayuda_clave" style="display:none;">Deje en blanco si no desea cambiarla.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>