<div class="about-us mt-5">
    <div class="container">
        <div class="title-container text-center ">
            <h2 class="fw-bold">ABOUT US</h2>
        </div>
        <div class="row mt-5">
            <div class="col-md-6" data-aos="fade-right">
                <h3 class="fw-bold about-us-title">
                    {{$about->judul}}
                </h3>
                <p class="fw-bolder mt-4 about-us-subtitle">
                    {{$about->subjudul}}
                </p>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <p>
                    {{$about->deskripsi_1}}
                </p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fa fa-check-double primary"></i>
                        {{$about->kelebihan_1}}
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-check-double primary"></i>
                        {{$about->kelebihan_2}}
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-check-double primary"></i>
                        {{$about->kelebihan_3}}
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-check-double primary"></i>
                        {{$about->kelebihan_4}}
                    </li>
                </ul>
                <p class="mt-2">
                    {{$about->deskripsi_2}}
                </p>
            </div>
        </div>
    </div>
</div>