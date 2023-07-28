<!-- Modal -->

<div class="modal fade" id="myModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

                       <div class='mb-3'>
                        <label class='form-label' for='name'>Name</label>
                        <input type='text' id='name' name='name' class='form-control' placeholder='Name'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='description'>Description</label>
                        <input type='text' id='description' name='description' class='form-control' placeholder='Description'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='logo'>Logo</label>
                        <input type='text' id='logo' name='logo' class='form-control' placeholder='Logo'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='alamat'>Alamat</label>
                        <input type='text' id='alamat' name='alamat' class='form-control' placeholder='Alamat'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='email'>Email</label>
                        <input type='text' id='email' name='email' class='form-control' placeholder='Email'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='telepon'>Telepon</label>
                        <input type='text' id='telepon' name='telepon' class='form-control' placeholder='Telepon'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='maps_embed'>Maps_embed</label>
                        <input type='text' id='maps_embed' name='maps_embed' class='form-control' placeholder='Maps_embed'>
                    </div>


                    <div class="modal-footer">
                        <button id="formSubmit" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

