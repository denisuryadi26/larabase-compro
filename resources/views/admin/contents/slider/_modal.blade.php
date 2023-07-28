<!-- Modal -->

<div class="modal fade" id="myModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" id="formModal" novalidate>
                    @csrf
                    <input type="hidden" name="id" id="id" class="id">

                    <div class='mb-3'>
                        <label class='form-label' for='title'>Title</label>
                        <input type='text' id='title' name='title' class='form-control' placeholder='Title'>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label' for='description'>Description</label>
                        <input type='text' id='description' name='description' class='form-control' placeholder='Description'>
                    </div>
                    <!-- <div class='mb-3'>
                        <label class='form-label' for='image'>Image</label>
                        <input type='text' id='image' name='image' class='form-control' placeholder='Image'>
                    </div> -->
                    <fieldset class="form-group floating-label-form-group">
                        <label class='form-label' for='image'>Image</label>
                        <input type="file" class="files" id="fileUpload" name="image" accept=".jpg,.gif,.png,.svg,.jpeg">
                    </fieldset>


                    <div class="modal-footer">
                        <button id="formSubmit" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>