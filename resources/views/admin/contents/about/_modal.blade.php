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
                        <label class='form-label' for='judul'>Judul</label>
                        <input type='text' id='judul' name='judul' class='form-control' placeholder='Judul'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='subjudul'>Subjudul</label>
                        <input type='text' id='subjudul' name='subjudul' class='form-control' placeholder='Subjudul'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='deskripsi_1'>Deskripsi_1</label>
                        <input type='text' id='deskripsi_1' name='deskripsi_1' class='form-control' placeholder='Deskripsi_1'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='deskripsi_2'>Deskripsi_2</label>
                        <input type='text' id='deskripsi_2' name='deskripsi_2' class='form-control' placeholder='Deskripsi_2'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='kelebihan_1'>Kelebihan_1</label>
                        <input type='text' id='kelebihan_1' name='kelebihan_1' class='form-control' placeholder='Kelebihan_1'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='kelebihan_2'>Kelebihan_2</label>
                        <input type='text' id='kelebihan_2' name='kelebihan_2' class='form-control' placeholder='Kelebihan_2'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='kelebihan_3'>Kelebihan_3</label>
                        <input type='text' id='kelebihan_3' name='kelebihan_3' class='form-control' placeholder='Kelebihan_3'>
                    </div> <div class='mb-3'>
                        <label class='form-label' for='kelebihan_4'>Kelebihan_4</label>
                        <input type='text' id='kelebihan_4' name='kelebihan_4' class='form-control' placeholder='Kelebihan_4'>
                    </div>


                    <div class="modal-footer">
                        <button id="formSubmit" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

