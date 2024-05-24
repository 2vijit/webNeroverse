@extends('frontend.layouts.main')
@section('title')
{{ 'Home' }}
@endsection
@section('header.css')
<style>

</style>
@endsection
@section('main.content')
<section id="hero" class="hero d-flex align-items-center">
    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/Ellipse 4.png') }}" alt="" class="circleCenter">
    <div class="aboutImageColumnMod">
        <div class="row gy-4 d-flex justify-content-between">
            <div class="col-lg-6 order-2 order-lg-1  d-flex flex-column justify-content-center header-text">
                <h2 data-aos="fade-up" class="px-4">
                    About Us
                </h2>
                <p data-aos="fade-up" data-aos-delay="100" class="px-4" style="width: 70%;">
                    Neuroverse is a global IT services provider, focusing on Website Development, cloud solutions, AR/VR
                    app
                    development, digital marketing, mobile App development and cyber security. Our skilled team delivers
                    high-quality solutions tailored to our client’s needs. We strive to deliver innovative and
                    user-friendly
                    solutions.
                    With our comprehensive IT services, we aim to help businesses achieve their goals and stay ahead in
                    today's
                    competitive market. </p>

                <a href="{{ route('downloadPdf', ['id' => $document]) }}">
                    <button class="get-started get-started-about " data-aos="fade-up" data-aos-delay="400">
                        Our Details
                    </button>
                </a>
                <!-- <div class="row gy-4" data-aos="fade-up" data-aos-delay="400"></div> -->
            </div>



            <div class="container col-lg-5 order-1 order-lg-2 hero-img hero-img-about aboutImageMob" data-aos="zoom-out"
                style="z-index: 1; top : 15%">
                <div class="row mt-5">
                    <div class="col-lg-12 d-flex  justify-content-center">
                        <img src="{{ asset('public/frontend/assets/img/Rectangle 14.png') }}"
                            class="img-fluid mb-3 mb-lg-0" alt="" data-aos="fade-down" />

                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <img src="{{ asset('public/frontend/assets/img/Rectangle 14.png') }}"
                            class="img-fluid mb-3 mb-lg-0" alt="" data-aos="fade-up" />

                    </div>

                </div>



            </div>
        </div>
    </div>
</section>
<!-- End Hero Section -->

<main id="main">
    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/Ellipse 8.png') }}" alt="" class="ellipse8"
        style="top:220%">

    <img data-aos="fade-up" src="{{ asset('public/frontend/assets/img/Ellipse 7.png') }}" alt="" class="ellipse7">
    <section id="features" class="features ">
        <div class="container">
            <div class="row gy-4 align-items-center features-item offset-md-1" data-aos="fade-up">
                <div class="col-md-6">
                    <img src="{{ asset('public/frontend/assets/img/solution.png') }}" class="img-fluid about-image"
                        alt="" />
                </div>
                <div class="col-md-5 ">
                    <h3 class="" style="
                            display: flex;
                            flex-direction: row;
                            font-family: IBM Plex Sans;
                            font-size: 35px;
                            font-weight: 700;
                            text-align: center;
                            color: #0F5587;
                            margin: 0;
                            padding: 0;
                            line-height: 1.2;
                            width: max-content;
                            ">
                        We are<span style="margin: 0px 5px 0px 5px;
                                font-family: IBM Plex Sans;
                                font-size: 35px;
                                font-weight: 700;
                                line-height: 63.98px;
                                text-align: left;
                                color: #43C6E7;
                                padding: 0;
                                line-height: 1.2;">complete
                            solution</span>of every idea</h3>

                    <p class="fst-italic">
                        In our journey, we embrace every spark of creativity. From concept to execution, we’re the
                        architects of
                        transformation, unleash potential and shape tomorrow.
                        With unwavering commitment, we turn ideas into reality, propelling innovation and progress.
                    </p>

                </div>
            </div>
        </div>
    </section>

    <div class="" style="
        background: #F5FDFF;
        position: relative;
        display: flex;
        flex-direction: row;
        flex-grow: 1;
        flex-shrink: 1;
        overflow: hidden;
        align-items: stretch;
        justify-content: center;">
        <div class="fixedRoute">
            <div class="container" style="margin-bottom: 10%">
                <div class="infoContent" style="text-align: center;
                    display: flex;
                    flex-direction: column;
                    align-items: center;">
                    <h3 class="midText">Our Goals</h3>
                    <p class="fst-italic" style="text-align: center">Business generally promote their brand,
                        products, and service by identifying
                        audience
                    </p>
                </div>
                <div>
                    <div class=" row mt-5">
                        <div class="col-lg-4 col-sm-12 cardRow1">

                            <div class="cardBody" data-aos="fade-up" data-aos-delay="100">
                                <div>
                                    <div class="cercle mt-5"></div>
                                    <div>
                                        <h4 class="mt-2">Mission
                                        </h4>
                                    </div>
                                    <div>

                                        <p>To harness local talent and global opportunities for technological
                                            advancement.</p>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-4 col-sm-12 cardRow1">
                            <div class="cardBody" data-aos="fade-up" data-aos-delay="200">
                                <div>
                                    <div class="cercle mt-5"></div>
                                    <div>
                                        <h4 class="mt-2">Vission
                                        </h4>
                                    </div>
                                    <div>

                                        <p>
                                            To establish lasting partnerships with clients built on mutual growth.
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 cardRow1">
                            <div class="cardBody " data-aos="fade-up" data-aos-delay="300">
                                <div>
                                    <div class="cercle mt-5"></div>
                                    <div>
                                        <h4 class="mt-2"> Values
                                        </h4>
                                    </div>
                                    <div>
                                        <p> Integrity, Boldness, Honesty, Honesty, Trust and Accountability. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="service" class="our-team pt-0" data-aos="fade-up">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="midText" style="justify-content: space-evenly;">Our Team</h3>
            </div>

            <div class="row gy-4" data-aos="fade-up">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-sm-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card text-center caseStudyCard" style="background-color: rgba(67, 198, 231, 0.2);">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/team/team-1.jpg') }}" alt=""
                                class="img-fluid" />
                        </div>
                        <div class="card-body">
                            <hr class="cardDivider">
                            <h3>
                                <a href="service-details.html" class="card-title">Tushar Karmokar</a>
                            </h3>
                            <p class="card-text offset-md-1">
                                Lead Desingner
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Card Item -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-sm-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card text-center caseStudyCard" style="background-color: rgba(67, 198, 231, 0.2);">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/team/team-2.jpg') }}" alt=""
                                class="img-fluid" />
                        </div>
                        <div class="card-body">
                            <hr class="cardDivider">
                            <h3>
                                <a href="service-details.html" class="card-title">Tushar Karmokar</a>
                            </h3>
                            <p class="card-text offset-md-1">
                                Lead Desingner
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Card Item -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-sm-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card text-center caseStudyCard" style="background-color: rgba(67, 198, 231, 0.2);">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/team/team-3.jpg') }}" alt=""
                                class="img-fluid" />
                        </div>
                        <div class="card-body">
                            <hr class="cardDivider">
                            <h3>
                                <a href="service-details.html" class="card-title">Tushar Karmokar</a>
                            </h3>
                            <p class="card-text offset-md-1">
                                Lead Desingner
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Card Item -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-sm-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="card text-center caseStudyCard" style="background-color: rgba(67, 198, 231, 0.2);">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/team/team-1.jpg') }}" alt=""
                                class="img-fluid" />
                        </div>
                        <div class="card-body">
                            <hr class="cardDivider">
                            <h3>
                                <a href="service-details.html" class="card-title">Tushar Karmokar</a>
                            </h3>
                            <p class="card-text offset-md-1">
                                Lead Desingner
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Card Item -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-sm-3" data-aos="fade-up" data-aos-delay="500">
                    <div class="card text-center caseStudyCard" style="background-color: rgba(67, 198, 231, 0.2);">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/team/team-3.jpg') }}" alt=""
                                class="img-fluid" />
                        </div>
                        <div class="card-body">
                            <hr class="cardDivider">
                            <h3>
                                <a href="service-details.html" class="card-title">Tushar Karmokar</a>
                            </h3>
                            <p class="card-text offset-md-1">
                                Lead Desingner
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Card Item -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-sm-3" data-aos="fade-up" data-aos-delay="600">
                    <div class="card text-center caseStudyCard" style="background-color: rgba(67, 198, 231, 0.2);">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/team/team-2.jpg') }}" alt=""
                                class="img-fluid" />
                        </div>
                        <div class="card-body">
                            <hr class="cardDivider">
                            <h3>
                                <a href="service-details.html" class="card-title">Tushar Karmokar</a>
                            </h3>
                            <p class="card-text offset-md-1">
                                Lead Desingner
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Card Item -->

            </div>
        </div>
    </section>

    <!-- ======= Latest New Section ======= -->
    <section id="service" class="services pt-0 latest-news">
        <div class="container" data-aos="fade-up">
            <div class="mb-4 mt-3">

                <h2>Latest News</h2>
            </div>

            <div class="row gy-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/news1.png') }}" alt="" class="img-fluid" />
                        </div>
                        <h3>
                            <a href="https://techcrunch.com/" class="stretched-link">How to Grow your Business with
                                Self
                                Preuner and
                                Agency</a>
                        </h3>
                        <p>
                            Cumque eos in qui numquam. Aut aspernatur perferendis sed
                            atque quia voluptas quisquam repellendus temporibus
                            itaqueofficiis odit
                        </p>
                    </div>
                </div>
                <!-- End Card Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/news2.png') }}" alt="" class="img-fluid" />
                        </div>
                        <h3>
                            <a href="https://www.wired.com/" class="stretched-link">How to Grow your Business with
                                Self
                                Preuner and
                                Agency</a>
                        </h3>
                        <p>
                            Asperiores provident dolor accusamus pariatur dolore nam id
                            audantium ut et iure incidunt molestiae dolor ipsam ducimus
                            occaecati nisi
                        </p>
                    </div>
                </div>
                <!-- End Card Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="card">
                        <div class="card-img">
                            <img src="{{ asset('public/frontend/assets/img/news3.png') }}" alt="" class="img-fluid" />
                        </div>
                        <h3>
                            <a href="https://www.computerworld.com/" class="stretched-link">How to Grow your Business
                                with Self
                                Preuner and Agency</a>
                        </h3>
                        <p>
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
    <!-- End Services Section -->
</main>
@endsection
@section('footer.js')
@endsection