<!-- Modal -->
<!-- Modal -->
<div class="modal fade text-left" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" id="formModal"
                      novalidate>
                    @csrf
                    <input type="hidden" name="id" id="id" class="id">

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Parameter</label>
                        <input type="text" id="parameter" name="parameter" class="form-control" placeholder="Parameter">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Type</label>
                        <div class="controls">
                            <select class="js-example-basic-single form-control" id="type" name="type">
                                <option value="text">Text</option>
                                <option value="upload">Upload</option>
                                <option value="editor">Editor</option>

                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Value</label>

                        <textarea class="form-control" id="value" name="value"></textarea>
                        <input type="file" class="files hidden" id="fileUpload">
                         {{--<fieldset class="form-group floating-label-form-group">
                             <label for="user-name">Parameter</label>
                             <div class="controls">
                                 <input type="text" class="form-control" id="parameter" name="parameter"
                                        placeholder="Parameter"
                                        data-validation-required-message="This field is required">
                             </div>
                         </fieldset>

                         <fieldset class="form-group floating-label-form-group">
                             <label for="group">Type</label>
                             <div class="controls">
                                 <select class="js-example-basic-single form-control" id="type" name="type">
                                     <option value="text">Text</option>
                                     <option value="upload">Upload</option>
                                     <option value="editor">Editor</option>

                                 </select>
                             </div>
                         </fieldset>

                         <fieldset class="form-group floating-label-form-group">
                             <label for="user-name">Value</label>
                             <div class="controls">
                                 {{--                            <input type="text" class="form-control" id="value" name="value"--}}
                            {{--                                   placeholder="Value"--}}
                            {{--                                   data-validation-required-message="This field is required">--}}
                       {{-- </div>
                        <textarea class="form-control" id="value" name="value"></textarea>
                        <input type="file" class="files hidden" id="fileUpload">
                    </fieldset>--}}

                    <div class="modal-footer">
                        <button id="save" type="submit" class="btn btn-outline-info save">Save changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


