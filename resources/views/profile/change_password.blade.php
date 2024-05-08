<div id="changePasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            {!! Form::open(['route' => 'usuario.editarpass', 'method' => 'POST', 'class' => 'formulario']) !!}
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Actual Contraseña:</label><span
                                    class="required confirm-pwd"></span><span class="obligatorio">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="pfCurrentPassword" type="password"
                                       name="password_current" required>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Nueva Contraseña:</label><span
                                    class="required confirm-pwd"></span><span class="obligatorio">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="pfNewPassword" type="password"
                                       name="password" required>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Confirmar Contraseña:</label><span
                                    class="required confirm-pwd"></span><span class="obligatorio">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="pfNewConfirmPassword" type="password"
                                       name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                         
                        {!! Form::close() !!}
                        {{-- <button type="submit" class="btn btn-success" id="btnPrPasswordEditSave"
                                data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing...">
                            Guardar
                        </button> --}}
                        <button type="button" class="btn btn-danger ml-1 edit-cancel-margin margin-left-5"
                                data-dismiss="modal">Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
