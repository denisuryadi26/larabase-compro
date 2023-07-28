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

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Group</label>
                        <!-- Select -->
                        <div class="controls">

                            <!-- <select class="form-control js-example-basic-single" id="group" name="group_id" style="padding:10px !important;"> -->
                            <select class="select2 form-select form-select-lg" id="group" name="group_id" style="padding:10px !important;">
                                @foreach($group as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach

                            </select>

                        </div>
                        <!-- End Select -->
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Full Name</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Full Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Enter Password</label>

                        <div class="controls">
                            <input type="password" name="password" id="password" class="form-control" required data-validation-required-message="This field is required" placeholder="Enter Password">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Confirm Password</label>
                        <div class="controls">
                            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" data-validation-required-message="This field is required">
                            <p class="invalid" hidden>Password Not Match</p>


                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="formSubmit" type="submit" class="btn btn-outline-info">Save changes</button>
            </div>
        </div>
    </div>
</div>