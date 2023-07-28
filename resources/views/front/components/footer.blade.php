<footer class="mt-5">
    <div class="footer-top bg-dark text-white p-5 ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <h4 class="fw-bold">{{$contact->name}}</h2>
                        <p>
                            {{$contact->description}}
                        </p>
                        <strong>Phone</strong> : <span>{{$contact->telepon}} </span>
                        <br />
                        <strong>Email</strong> : <span>{{$contact->email}} </span>
                </div>
                <div class="col-md-2">
                    <h4 class="fw-bold">Our Services</h2>
                        <ul class="list-group list-unstyled">
                            @foreach($services as $service)
                            <li class="list-item">
                                <a href="" class="text-decoration-none text-white">
                                    <i class="fa fa-chevron-right primary"></i>
                                    {{$service->title}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                </div>
                <div class="col-md-2">
                    <h4 class="fw-bold">Useful Links</h2>
                        <ul class="list-group list-unstyled">
                            <li class="list-item">
                                <a href="" class="text-decoration-none text-white">
                                    <i class="fa fa-chevron-right primary"></i>
                                    Home
                                </a>
                            </li>
                            <li class="list-item">
                                <a href="" class="text-decoration-none text-white">
                                    <i class="fa fa-chevron-right primary"></i>
                                    About Us
                                </a>
                            </li>
                            <li class="list-item">
                                <a href="" class="text-decoration-none text-white">
                                    <i class="fa fa-chevron-right primary"></i>
                                    Services
                                </a>
                            </li>
                            <li class="list-item">
                                <a href="" class="text-decoration-none text-white">
                                    <i class="fa fa-chevron-right primary"></i>
                                    Portfolio
                                </a>
                            </li>
                            <li class="list-item">
                                <a href="" class="text-decoration-none text-white">
                                    <i class="fa fa-chevron-right primary"></i>
                                    Contact
                                </a>
                            </li>
                        </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="fw-bold">Join Our Newsletter</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </p>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="yourmail@example.com" />
                            <button class="btn btn-subscribe" type="button" id="inputGroupFileAddon04">
                                Subscribe
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-down bg-darker text-white px-5 py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="copyright">
                        &copy; Copyright <strong>Company</strong>. All Right Reserved
                    </div>
                    <div class="credits">
                        Design by me
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="social-links float-end">
                        <a href="" class="mx-2">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                        <a href="" class="mx-2">
                            <i class="fab fa-twitter fa-2x"></i>
                        </a>
                        <a href="" class="mx-2">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>
                        <a href="" class="mx-2">
                            <i class="fab fa-youtube fa-2x"></i>
                        </a>
                        <a href="" class="mx-2">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>