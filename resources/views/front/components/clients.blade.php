<div class="clients mt-5">
    <div class="container">
        <div class="title-container">
            <h2 class="text-center fw-bold">CLIENTS</h2>
        </div>
        <div class="row mt-5">
            @foreach($clients as $client)
            <div class="col-md-3 pt-5 text-center" data-aos="zoom-in">
                <img src="{{asset('storage/images/')}}/{{$client->image}}" class="img-fluid brand-image" alt="" />
            </div>
            @endforeach
        </div>
    </div>
</div>