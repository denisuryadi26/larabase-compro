<div class="services mt-5 bg-light py-5">
    <div class="container">
        <div class="title-container text-center">
            <h2 class="fw-bold">SERVICES</h2>
        </div>
        <p class="text-center mt-4">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus,
            aliquam.
        </p>
        <div class="row mt-5">
            @foreach($services as $service)
            <div class="col-md-4">
                <div class="card border-0 text-center p-4 mt-3" data-aos="zoom-in">
                    <div class="card-body">
                        <div class="card-icon">
                            <img src="{{asset('storage/images/')}}/{{$service->image}}" alt="" class="img-fluid" width="80">
                        </div>
                        <div class="card-title fw-bolder mt-4">{{$service->title}}</div>
                        <p class="card-description mt-3">
                            {{$service->description}}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>