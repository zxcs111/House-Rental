<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stay Haven</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="{{ asset('user-template/css/open-iconic-bootstrap.min.css') }}">   
    <link rel="stylesheet" href="{{ asset('user-template/css/animate.css') }}"> 
    <link rel="stylesheet" href="{{ asset('user-template/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/welcome.css') }}">
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
          <a class="navbar-brand" href="{{ route('home') }}">Stay<span> Haven</span></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="oi oi-menu"></span> Menu
          </button>

          <div class="collapse navbar-collapse" id="ftco-nav">
              <ul class="navbar-nav ml-auto">
                  @auth
                      @if(Auth::user()->role === 'tenant')
                          <!-- Tenant Menu Items -->
                          <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                          <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                          <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                          <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                          <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                      @elseif(Auth::user()->role === 'landlord')
                          <!-- Landlord Menu Items (restricted access) -->
                          <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                          <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                          <li class="nav-item"><a href="{{ route('property.listing') }}" class="nav-link">Property Listing</a></li>
                          <li class="nav-item">
                              <a href="{{ route('landlord.cancellation-requests') }}" class="nav-link">
                                  Cancellation Requests
                                  @if(($pendingCancellationCount ?? 0) > 0)
                                      <span class="badge bg-danger">{{ $pendingCancellationCount }}</span>
                                  @endif
                              </a>
                          </li>
                          <li class="nav-item"><a href="{{ route('landlord.financial-reporting') }}" class="nav-link">Financial Reporting</a></li>
                      @endif
                      <!-- Profile Dropdown (Common for both roles) -->
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              @if(Auth::user()->profile_picture)
                                  <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                              @else
                                  <i class="fas fa-user-circle" style="font-size: 24px;"></i>
                              @endif
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                              <a class="dropdown-item" href="{{ route('messages.index') }}">Messages</a>
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  Logout
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </div>
                      </li>
                  @else
                      <!-- Default Menu Items (for non-logged in users) -->
                      <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                      <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                      <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                      <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                      <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                      <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                  @endauth
              </ul>
          </div>
      </div>
    </nav>
    <!-- END nav -->
    
    <div class="hero-wrap ftco-degree-bg" style="background-image: url('user-template/images/landing-image.jpg')" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
          <div class="col-lg-8 ftco-animate">
            <div class="text w-100 text-center mb-md-5 pb-md-5">
              <h1 class="mb-4">Fast & Easy Way To Rent A Home</h1>
              <p style="font-size: 18px;">A charming neighborhood surrounds our rental home, providing a peaceful atmosphere and essential amenities. It is a tranquil haven, where comfort meets convenience.</p>
              <a href="user-template/images/Stay Haven.mp4" class="icon-wrap popup-vimeo d-flex align-items-center mt-4 justify-content-center">
                <div class="icon d-flex align-items-center justify-content-center">
                  <span class="ion-ios-play"></span>
                </div>
                <div class="heading-title ml-5">
                  <span>Easy steps for renting a house</span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-no-pt bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 heading-section text-center ftco-animate mb-5">
                    <span class="subheading">What we offer</span>
                    <h2 class="mb-2">Available Properties</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($featuredProperties->isEmpty())
                        <div class="col-md-12 text-center">
                            <p>No properties available at the moment. Please check back later.</p>
                        </div>
                    @else
                        <div class="carousel-car owl-carousel">
                            @foreach($featuredProperties as $property)
                                <div class="item">
                                    <div class="car-wrap rounded ftco-animate">
                                        <div class="img rounded d-flex align-items-end" style="background-image: url('{{ $property->main_image_url }}');">
                                        </div>
                                        <div class="text">
                                            <h2 class="mb-0"><a href="{{ route('house-detail', $property->id) }}">{{ $property->title }}</a></h2>
                                            <div class="d-flex mb-3">
                                                <span class="cat">{{ $property->property_type }}</span>
                                                <p class="price ml-auto">${{ number_format($property->price, 2) }} <span>/month</span></p>
                                            </div>
                                            <p class="d-flex mb-0 d-block">
                                                @auth
                                                    @if(Auth::user()->role === 'tenant')
                                                        <a href="{{ route('payment.form', $property->id) }}" class="btn btn-primary py-2 mr-1">Rent now</a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-primary py-2 mr-1">Login to Rent</a>
                                                @endauth
                                                <a href="{{ route('house-detail', $property->id) }}" class="btn btn-secondary py-2 ml-1">Details</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="text-center mt-4">
                        <a href="{{ route('houses') }}" class="btn btn-primary">View All Properties</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-about">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(user-template/images/about-landing.jpg);">
          </div>
          <div class="col-md-6 wrap-about ftco-animate">
            <div class="heading-section heading-section-white pl-md-5">
              <span class="subheading">About us</span>
              <h2 class="mb-4">Welcome to Stay Haven</h2>
              <p>Discover your perfect home with Stay Haven, where a variety of stunning properties await you. Our experienced team is dedicated to helping you find the ideal space that suits your lifestyle and needs.</p>
              <p>Whether you’re looking for a cozy apartment in the city or a spacious house in the suburbs, we have the right options for you. Explore our listings to find the perfect place to call home.</p>
              <p><a href="{{ route('houses') }}" class="btn btn-primary py-3 px-4">View Available Properties</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
          <div class="row justify-content-center mb-5">
              <div class="col-md-7 text-center heading-section ftco-animate">
                  <span class="subheading">Services</span>
                  <h2 class="mb-3">Our Latest Services</h2>
              </div>
          </div>
          <div class="row text-center">
              <div class="col-md-3">
                  <div class="services services-2 w-100 text-center">
                      <div class="icon d-flex align-items-center justify-content-center">
                          <span class="bi bi-house-heart" style="font-size: 2rem;"></span>
                      </div>
                      <div class="text w-100">
                          <h3 class="heading mb-2">Relaxing Retreats</h3>
                          <p>Experience tranquility in our serene accommodations designed for ultimate relaxation and comfort.</p>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="services services-2 w-100 text-center">
                      <div class="icon d-flex align-items-center justify-content-center">
                          <span class="bi bi-person-check" style="font-size: 2rem;"></span>
                      </div>
                      <div class="text w-100">
                          <h3 class="heading mb-2">Personalized Getaways</h3>
                          <p>Custom-tailored stay packages that let you unwind and recharge in a peaceful environment.</p>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="services services-2 w-100 text-center">
                      <div class="icon d-flex align-items-center justify-content-center">
                          <span class="bi bi-map" style="font-size: 2rem;"></span>
                      </div>
                      <div class="text w-100">
                          <h3 class="heading mb-2">Serene City Tours</h3>
                          <p>Explore the charm of the city while enjoying a restful stay at Stay Haven, where comfort meets adventure.</p>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="services services-2 w-100 text-center">
                      <div class="icon d-flex align-items-center justify-content-center">
                          <span class="bi bi-car-front" style="font-size: 2rem;"></span>
                      </div>
                      <div class="text w-100">
                          <h3 class="heading mb-2">Luxury Transport Services</h3>
                          <p>Experience effortless travel with our premium transport options tailored for your convenience during your stay.</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
    
    <section class="ftco-section testimony-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <span class="subheading">Testimonial</span>
            <h2 class="mb-3">Happy Clients</h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url('user-template/images/person_1.jpg')">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">Marketing Manager</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url('user-template/images/person_2.jpg')">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">Interface Designer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url('user-template/images/person_3.jpg')">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">UI Designer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url('user-template/images/person_1.jpg')">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">Web Developer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url('user-template/images/person_1.jpg')">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">System Analyst</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <span class="subheading">FAQ</span>
            <h2>Frequently Asked Questions</h2>
          </div>
        </div>
        <div class="row d-flex">
          <div class="col-md-12 ftco-animate">
            <div class="accordion" id="faqAccordion">
              <!-- FAQ Item 1 -->
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      How does Stay Haven help me find the perfect rental home?
                      <span class="arrow"><i class="fas fa-chevron-down"></i></span>
                    </button>
                  </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                  <div class="card-body">
                    Stay Haven offers a user-friendly platform with a wide range of rental properties, from cozy apartments to spacious houses. Our experienced team provides personalized support to match your lifestyle and needs, ensuring you find a home that feels just right. Browse our listings, filter by preferences, and connect with landlords directly through our platform.
                  </div>
                </div>
              </div>
              <!-- FAQ Item 2 -->
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      What is the process for renting a property through Stay Haven?
                      <span class="arrow"><i class="fas fa-chevron-down"></i></span>
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                  <div class="card-body">
                    To rent a property, start by browsing available listings on Stay Haven. Once you find a property you like, log in as a tenant to access the "Rent Now" option. Complete the payment form, submit any required documents, and coordinate with the landlord for lease signing and move-in details. Our platform streamlines the process for a hassle-free experience.
                  </div>
                </div>
              </div>
              <!-- FAQ Item 3 -->
              <div class="card">
                <div class="card-header" id="headingThree">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Can landlords list their properties on Stay Haven?
                      <span class="arrow"><i class="fas fa-chevron-down"></i></span>
                    </button>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                  <div class="card-body">
                    Yes! Landlords can easily list their properties on Stay Haven by creating an account and accessing the "Property Listing" feature. You can upload photos, set pricing, and manage bookings. Our platform also provides tools like financial reporting and cancellation request management to simplify property management.
                  </div>
                </div>
              </div>
              <!-- FAQ Item 4 -->
              <div class="card">
                <div class="card-header" id="headingFour">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      What if I need to cancel a rental agreement?
                      <span class="arrow"><i class="fas fa-chevron-down"></i></span>
                    </button>
                  </h5>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                  <div class="card-body">
                    Tenants can submit a cancellation request through their Stay Haven account. The request will be reviewed by the landlord, who can approve or deny it based on the lease terms. Landlords can manage cancellation requests via the "Cancellation Requests" section in their dashboard, ensuring clear communication and transparency.
                  </div>
                </div>
              </div>
              <!-- FAQ Item 5 -->
              <div class="card">
                <div class="card-header" id="headingFive">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                      How can I contact Stay Haven for support?
                      <span class="arrow"><i class="fas fa-chevron-down"></i></span>
                    </button>
                  </h5>
                </div>
                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#faqAccordion">
                  <div class="card-body">
                    You can reach Stay Haven’s support team via the "Contact Us" page on our website, by emailing johnlloydjustiniane13@gmail.com, or by calling +63 995 5142 653. We also offer a messaging feature for logged-in users to communicate directly with landlords or our support staff for quick assistance.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>	

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2"><a href="#" class="logo">Stay<span> Haven</span></a></h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Information</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Services</a></li>
                <li><a href="#" class="py-2 d-block">Term and Conditions</a></li>
                <li><a href="#" class="py-2 d-block">Best Price Guarantee</a></li>
                <li><a href="#" class="py-2 d-block">Privacy & Cookies Policy</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Customer Support</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">FAQ</a></li>
                <li><a href="#" class="py-2 d-block">Payment Option</a></li>
                <li><a href="#" class="py-2 d-block">Booking Tips</a></li>
                <li><a href="#" class="py-2 d-block">How it works</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Have a Questions?</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon icon-map-marker"></span><span class="text">Lapu-Lapu City, Cebu, Philippines</span></li>
                  <li><a href="#"><span class="icon icon-phone"></span><span class="text">+63 995 5142 653</span></a></li>
                  <li><a href="#"><span class="icon icon-envelope"></span><span class="text">stayhaven@gmail.com</span></a></li>
                </ul> 
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright ©<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

    <!-- Pass session data via JSON script tag -->
    <script id="welcome-data" type="application/json">
    {
        "success": @json(Session::get('success')),
        "error": @json(Session::get('error'))
    }
    </script>

    <!-- Chatbase Chatbot Script -->
    <script>
      window.chatbaseConfig = {
        chatbotId: "4RSSrtK8VY3M7j0m4Tiye", // Replace with your actual Chatbase chatbot ID
      };
    </script>
    <script src="https://www.chatbase.co/embed.min.js" defer></script>

    <script src="{{ asset('user-template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('user-template/js/popper.min.js') }}"></script>
    <script src="{{ asset('user-template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('user-template/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('user-template/js/aos.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('user-template/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('user-template/js/scrollax.min.js') }}"></script>
    <script src="{{ asset('user-template/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('user-template/js/welcome.js') }}"></script>
    
  </body>
</html>