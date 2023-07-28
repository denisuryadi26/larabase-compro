<!doctype html>
<html lang="en">

@include('front.components.head')

<body>
    <!-- navbar -->
    @include('front.components.header')
    <!-- end navbar -->

    <!-- carousel -->
    @include('front.components.sliders')
    <!-- end carousel -->

    <!-- about us -->
    @include('front.components.about')
    <!-- end about us -->

    <!-- services -->
    @include('front.components.services')
    <!-- end services -->

    <!-- portfolio us -->
    @include('front.components.portfolio')
    <!-- end portfolio us -->

    <!-- clients -->
    @include('front.components.clients')
    <!-- end clients -->

    <!-- footer -->
    @include('front.components.footer')
    <!-- end footer  -->

    <!-- to top -->
    <a href="#" class="btn-to-top p-3">
        <i class="fa fa-chevron-up"></i>
    </a>
    <!-- end to top -->

    @include('front.components.js')
</body>

</html>