@extends('frontend.layouts.main')
@section('title')
    {{ 'Home' }}
@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')
    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs mb-4">
            <div class="page-header d-flex align-items-center">
                <div class="container position-relative">
                    <img src="{{ asset('public/frontend/assets/img/online-survey-image.png') }}"
                        style="
                    width: 1026px;
                    height: 467px;
                    mix-blend-mode: multiply;
                    margin-left: 8%;
                    background-blend-mode: multiply;
                " />
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h2>Case Studies</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->

        <!-- ======= Featured Services Section ======= -->

        <!-- End Featured Services Section -->

        <!-- ======= Services Section ======= -->
        <section id="service" class="pt-0 case-study-service">
            <div class="container" data-aos="fade-up">
                <div class="row mx-auto justify-content-md-center offset-sm-4">
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-sm-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="card text-center caseStudyCard" style="width: 18rem">
                            <div class="card-img">
                                <img src="{{ asset('public/frontend/assets/img/news1.png') }}" alt=""
                                    class="img-fluid custom-image" style="max-height: 200px; width: 600px" />
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"> The New Era of Cloud Computing </h5>
                                <p class="card-text offset-md-1">
                                    With supporting text below as a natural lead-in to
                                    additional content.
                                </p>
                                <hr class="cardDivider">
                                <a href="#" class="cardReadMore">Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Card Item -->

                    <div class="col-lg-4 col-md-4 col-sm-12" data-aos="fade-up" data-aos-delay="100">
                        <div class="card text-center caseStudyCard" style="width: 18rem">
                            <div class="card-img">
                                <img src="{{ asset('public/frontend/assets/img/news1.png') }}" alt=""
                                    class="img-fluid custom-image" style="max-height: 200px; width: 600px" />
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"> The New Era of Cloud Computing </h5>
                                <p class="card-text offset-md-1">
                                    With supporting text below as a natural lead-in to
                                    additional content.
                                </p>
                                <hr class="cardDivider">
                                <a href="#" class="cardReadMore">Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Card Item -->
                    <div class="col-lg-4 col-md-4 col-sm-12" data-aos="fade-up" data-aos-delay="100">
                        <div class="card text-center caseStudyCard" style="width: 18rem">
                            <div class="card-img">
                                <img src="{{ asset('public/frontend/assets/img/news1.png') }}" alt=""
                                    class="img-fluid custom-image" style="max-height: 200px; width: 600px" />
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"> The New Era of Cloud Computing </h5>
                                <p class="card-text offset-md-1">
                                    With supporting text below as a natural lead-in to
                                    additional content.
                                </p>
                                <hr class="cardDivider">
                                <a href="#" class="cardReadMore">Read More</a>
                            </div>
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
