<div id="EditProfileModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar perfil</h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            {!! Form::open(['route' => 'usuario.editar', 'method' => 'POST', 'class' => 'formulario']) !!}
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="editProfileValidationErrorsBox"></div>
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Nombre:</label><span class="obligatorio">*</span>
                            <input type="text" name="name" id="pfName" class="form-control" required autofocus
                                   tabindex="1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Email:</label><span class="obligatorio">*</span>
                            <input type="email" name="email" id="pfEmail" class="form-control" disabled tabindex="3">
                        </div>
                    </div>
                    <div class="text-right">
                         
                         {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                         
                         {!! Form::close() !!}
                        {{-- <button type="submit" class="btn btn-success" id="btnPrEditSave"
                                data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing..."
                                tabindex="5">Guardar
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

