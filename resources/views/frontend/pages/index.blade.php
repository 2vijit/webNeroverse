@extends('frontend.layouts.main')
@section('title')
{{ 'Home' }}
@endsection
@section('header.css')
<style>

</style>
@endsection
@section('main.content')
<section id="hero" class="hero  d-flex align-items-center">

    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/Ellipse 4.png') }}" alt="" class="circleCenter"
        style="top:2%">
    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/thinCircle.png') }}" alt="" class="thinCircle">
    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/Ellipse 1.png') }}" alt="" class="ellipse1">
    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/Ellipse 6.png') }}" alt="" class="ellipse6">

    <div class="">
        <div class="row gy-4 d-flex justify-content-between index-title">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center header-text">
                <h2 data-aos="fade-up" class="px-md-4">Let's Elevate Your Business</h2>
                <p data-aos="fade-up" data-aos-delay="100" class="px-4">
                    We work Professionally and Globally.
                </p>

                <div class="gy-4 px-4" data-aos="fade-up" data-aos-delay="400">
                    <button class="get-started">Get started</button>
                </div>
            </div>

            <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                <img src="{{ asset('public/frontend/assets/img/man.png') }}" class="img-fluid mb-3 mb-lg-0" alt=""
                    style="" />
            </div>
        </div>
    </div>
</section>
<!-- End Hero Section -->
<main id="main">
    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/Ellipse 8.png') }}" alt="" class="ellipse8"
        style="top: 400%">

    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/Ellipse 7.png') }}" alt="" class="ellipse7">

    {{-- --------------------------------- Our Mission Section --------------------------- --}}
    <section id="features" class="features">
        <div class="container">
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-md-4">
                    <img src="{{ asset('public/frontend/assets/img/findoutPicture.png') }}"
                        class="img-fluid about-image" alt="" />
                </div>
                <div class="col-md-4">
                    <div class="mt-lg-5 px-lg-3">
                        <h3 class="midText">Find out what <span>we do</span></h3>
                        <p class="fst-italic">
                            Our skilled team is committed to delivering high-quality
                            solutions, keeping pace with industry trends and innovation.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- --------------------------------- Our Mission Section --------------------------- --}}

    <!-- card -->
    {{-- --------------------------------- Our Works Section --------------------------- --}}
    <section class="boostImage" style="background-color: #f5fdff">
        <div class="container">
            <div class="infoContent">
                <div>
                    <div class="infoText">
                        <div class="hFourCol">
                            <h4 class="midText">
                                <span>Boost</span> your Business
                            </h4>
                            <h4 class="midText" style="margin-left: 15%;">
                                with our <span>Works.</span>
                            </h4>
                        </div>
                    </div>
                    <p id="midText_p">
                        Business generally promote their brand, products, and service by
                        identifying audience
                    </p>
                </div>
            </div>
            <div>
                <div class="row mt-5">
                    <div class="col-lg-4 col-sm-12 cardRow1">
                        <div class="cardBody" data-aos="fade-up" data-aos-delay="100">
                            <div>
                                <div class="cercle mt-5"></div>
                                <div>
                                    <h4 class="mt-2">Website Development</h4>
                                </div>
                                <div>
                                    <p>
                                        Crafting robust and user-friendly websites tailored to
                                        our clients requirements including web app.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 cardRow1">
                        <div class="cardBody" data-aos="fade-up" data-aos-delay="200">
                            <div>
                                <div class="cercle mt-5"></div>
                                <div>
                                    <h4 class="mt-2">Cloud Solutions</h4>
                                </div>
                                <div>
                                    <p>
                                        Leveraging cloud technologies to enhance scalability,
                                        efficiency, and cost-effectiveness with high security.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 cardRow1">
                        <div class="cardBody" data-aos="fade-up" data-aos-delay="300">
                            <div>
                                <div class="cercle mt-5"></div>
                                <div>
                                    <h4 class="mt-2">AR/VR App Development</h4>
                                </div>
                                <div>
                                    <p>
                                        Creating immersive experiences through augmented reality
                                        (AR) and virtual reality (VR) applications.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-4 col-sm-12 cardRow1">
                    <div class="cardBody" data-aos="fade-up" data-aos-delay="400">
                        <div>
                            <div class="cercle mt-5"></div>
                            <div>
                                <h4 class="mt-2">Digital Marketing</h4>
                            </div>
                            <div>
                                <p>
                                    Strategizing and executing effective digital campaigns to
                                    boost brand visibility and engagement.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12 cardRow1">
                    <div class="cardBody" data-aos="fade-up" data-aos-delay="500">
                        <div>
                            <div class="cercle mt-5"></div>
                            <div>
                                <h4 class="mt-2">Mobile App Development</h4>
                            </div>
                            <div>
                                <p>
                                    Designing and developing mobile applications that resonate
                                    with the changes of the new world.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 cardRow1">
                    <div class="cardBody" data-aos="fade-up" data-aos-delay="600">
                        <div>
                            <div class="cercle mt-5"></div>
                            <div>
                                <h4 class="mt-2">Cybersecurity</h4>
                            </div>
                            <div>
                                <p>
                                    Ensuring data protection, threat detection, and risk
                                    mitigation with our certified skilled cybersecurity
                                    experts.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- card end -->
    <section id="features" class="home-page-features">
        <div class="container d-flex justify-content-center">
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-md-4 mt-lg-5">
                    <div class="hFourCol">
                        <h3 class="midText">Provide <span>Advanced</span></h3>
                        <h3 class="midText">
                            <span>Facilities</span> For
                        </h3>
                        <h3 class="midText">
                            Advanced <span>Client</span></h3>
                        </h3>
                    </div>
                    <p class="fst-italic">
                        We partner with businesses to help them achieve their goals and
                        stay competitive in today’s dynamic market.
                    </p>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('public/frontend/assets/img/provide advance facilities.png') }}"
                        class="img-fluid about-image" alt="" />
                </div>
            </div>
            <!-- Features Item -->
        </div>
    </section>
    {{-- --------------------------------- Our Works Section --------------------------- --}}
    <!-- ======= News Section======= -->
    <section id="service" class="services pt-0 latest-news">
        <div class="container" data-aos="fade-up">
            <div class="mb-4 mt-3">
                <h4 class="midText">Our <span>
                        Latest News
                    </span></h4>
            </div>

            <div class="row gy-4 mx-auto">
                <div class="col-lg-3 col-md-4 mx-lg-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="card">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/news1.png') }}" alt="" class="img-fluid" />
                        </div>
                        <h3>
                            <a href="https://techcrunch.com/" class="stretched-link">How to Grow your Business with
                                Self Preuner and
                                Agency</a>
                        </h3>
                        <p class="stretched-link_p">
                            Cumque eos in qui numquam. Aut aspernatur perferendis sed
                            atque quia voluptas quisquam repellendus temporibus
                            itaqueofficiis odit
                        </p>
                    </div>
                </div>
                <!-- End Card Item -->

                <div class="col-lg-3 col-md-4 mx-lg-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="card">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/news2.png') }}" alt="" class="img-fluid" />
                        </div>
                        <h3>
                            <a href="https://www.wired.com/" class="stretched-link">How to Grow your Business with
                                Self Preuner and
                                Agency</a>
                        </h3>
                        <p class="stretched-link_p">
                            Asperiores provident dolor accusamus pariatur dolore nam id
                            audantium ut et iure incidunt molestiae dolor ipsam ducimus
                            occaecati nisi
                        </p>
                    </div>
                </div>
                <!-- End Card Item -->

                <div class="col-lg-3 col-md-4 mx-lg-5" data-aos="fade-up" data-aos-delay="300">
                    <div class="card">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/news3.png') }}" alt="" class="img-fluid" />
                        </div>
                        <h3>
                            <a href="https://www.computerworld.com/" class="stretched-link">How to Grow your
                                Business with Self
                                Preuner and Agency</a>
                        </h3>
                        <p class="stretched-link_p">
                            Dicta quam similique quia architecto eos nisi aut ratione aut
                            ipsum reiciendis sit doloremque oluptatem aut et molestiae ut
                            et nihil
                        </p>
                    </div>
                </div>
                <!-- End Card Item -->
            </div>
        </div>
    </section>
    <!-- End News Section -->
</main>
@endsection
@section('footer.js')
@endsection