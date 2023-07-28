<!-- Modal -->
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
                        <label class="form-label" for="exampleFormControlInput4">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Full Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Parent</label>
                        <div class="controls">

                            <select class="form-control select2 form-select form-select-lg" id="parent" name="parent_id" style="padding:10px !important;">
                                {{-- @foreach($group as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach--}}
                            </select>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Code</label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="Code">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Order</label>
                        <input type="text" id="menu_order" name="menu_order" class="form-control number-only" placeholder="Order">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Route Name</label>
                        <input type="text" id="route_name" name="route_name" class="form-control" placeholder="Route Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput4">Icon</label>
                        <input type="text" id="icon" name="icon" class="form-control" placeholder="Icon">
                    </div>


                    <div class="modal-footer">
                        <button id="formSubmit" type="submit" class="btn btn-outline-info">Save changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>