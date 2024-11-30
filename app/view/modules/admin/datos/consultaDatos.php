<div class="row">
    <div class="col-sm-12">
        <h3>Gestión de datos</h3><br>
    </div>
</div>
<div class="row" style="margin-top: 5px;">
    <div class="col-sm-12">
        <form class="form-inline">
            <div class="form-group multiselect-datos" style="margin-bottom: 15px;">
                <label style="margin-bottom: 10px; color:#2fb56a;">
                    Dimensión
                </label>
                <select class="form-control" id="dimensionConsultaDatos" 
                        name="dimensionConsultaDatos" multiple="multiple"
                        >
                </select>
            </div>
            <div class="form-group multiselect-datos" style="margin-bottom: 15px;">
                <label style="margin-bottom: 10px; color:#2fb56a;">
                    Temática
                </label>
                <select class="form-control" id="tematicaConsultaDatos" 
                        name="tematicaConsultaDatos" multiple="multiple">
                </select>
            </div>
            <div class="form-group multiselect-datos" style="margin-bottom: 15px;">
                <label style="margin-bottom: 10px; color:#2fb56a;">
                    Indicador
                </label>
                <select class="form-control" id="indicadorConsultaDatos" 
                        name="indicadorConsultaDatos" multiple="multiple">
                </select>
            </div>
            <div class="form-group multiselect-datos" style="margin-bottom: 15px;">
                <label style="margin-bottom: 10px; color:#2fb56a;">
                    Tipo de zona geográfica
                </label>
                <select class="form-control" id="tipoZonaGeograficaConsultaDatos" 
                        name="tipoZonaGeograficaConsultaDatos" multiple="multiple">
                </select>
            </div>
            <div class="form-group multiselect-datos" style="margin-bottom: 15px;">
                <label style="margin-bottom: 10px; color:#2fb56a;">
                    Zona geográfica
                </label>
                <select class="form-control" id="zonaGeograficaConsultaDatos" 
                        name="zonaGeograficaConsultaDatos" multiple="multiple">
                </select>
            </div>
            <div class="form-group multiselect-datos" style="margin-bottom: 15px;">
                <label style="margin-bottom: 10px; color:#2fb56a;">
                    Desagregación temática
                </label>
                <select class="form-control" id="desagregacionTematicaConsultaDatos" 
                        name="desagregacionTematicaConsultaDatos" multiple="multiple">
                </select>
            </div>
            <div class="form-group" style="padding-top: 15px;" >
                <button type="button" class="btn btn-primary" id="btnConsultar" disabled 
                        onclick=consultarDatos()>
                    Consultar
                </button>     
            </div>
        </form>
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-dato-created">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header active">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Creación exitosa</h4>
                    </div>
                    <div class="modal-body">
                        <p id="modal-content-dato-created"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-btn-dato-created-ok">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>    
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-dato-edited">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header active">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edición exitosa</h4>
                    </div>
                    <div class="modal-body">
                        <p id="modal-content-dato-edited"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-btn-dato-edited-ok">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-dato-deleted">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header active">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Eliminación exitosa</h4>
                    </div>
                    <div class="modal-body">
                        <p id="modal-content-dato-deleted"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-btn-dato-deleted-ok">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-form-error">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header active" style="color: #fff !important;background-color: #dd4b39;border-color: #d73925; text-align: center;">
                        <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: #fff !important;background-color: #dd4b39;border-color: #d73925; text-align: center;">Error</h4>
                    </div>
                    <div class="modal-body">
                        <p id="modal-content-error">
                            Todos los campos son obligatorios.<br>
                            El número debe tener un formato válido.<br>
                            Verifica la información e intenta nuevamente.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-btn-form-error-ok">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top:30px;">
    <div class="col-sm-12">
        <div id="tabla-datos" hidden>
        </div>
    </div>
</div>