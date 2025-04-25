<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stay Haven - Houses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

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
    <link rel="stylesheet" href="{{ asset('user-template/css/houses.css') }}">
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
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
              @elseif(Auth::user()->role === 'landlord')
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                <li class="nav-item"><a href="{{ route('property.listing') }}" class="nav-link">Property Listing</a></li>
                <li class="nav-item">
                  <a href="{{ route('landlord.cancellation-requests') }}" class="nav-link">
                    Cancellation Requests
                    @if(($pendingCancellationCount ?? 0) > 0)
                      <span class="badge bg-danger">{{ $pendingCancellationCount }}</span>
                    @endif
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('landlord.financial-reporting') }}" class="nav-link">
                    Financial Reporting
                  </a>
                </li>
              @endif
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
              <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
              <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
              <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
              <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
              <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
              <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('user-template/images/house-landing.jpg') }}');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
            <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Houses <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Rent A House</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row mb-4">
          <div class="col-md-12 text-center">
            <form id="filterForm" method="GET" action="{{ route('houses') }}" class="d-flex align-items-center justify-content-center">
              <div class="form">
                <button type="button">
                  <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                    <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="#8b8ba7" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </button>
                <input class="input" id="searchInput" name="search" placeholder="Search by type, city, or title..." type="text" value="{{ request('search') }}">
                @if(request('search'))
                  <button class="reset" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" fill="none" viewBox="0 0 24 24" stroke="#8b8ba7">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </button>
                @endif
              </div>
              <div class="form-group ml-2">
                <select class="propertydropdown" id="propertyTypeDropdown" name="property_type">
                  <option value="">Select Type</option>
                  <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                  <option value="House" {{ request('property_type') == 'House' ? 'selected' : '' }}>House</option>
                  <option value="Condo" {{ request('property_type') == 'Condo' ? 'selected' : '' }}>Condo</option>
                  <option value="Townhouse" {{ request('property_type') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                  <option value="Duplex" {{ request('property_type') == 'Duplex' ? 'selected' : '' }}>Duplex</option>
                  <option value="Studio" {{ request('property_type') == 'Studio' ? 'selected' : '' }}>Studio</option>
                </select>
              </div>
            </form>
            <div class="col-12 text-center py-5 empty-state" style="display: none;">
              <i class="fas fa-home fa-4x text-muted mb-4"></i>
              <h4>No properties match your search criteria</h4>
              <p class="text-muted">Try adjusting your filters or search term.</p>
            </div>
          </div>
        </div>

        <div id="properties-container" class="row">
          @foreach($properties as $property)
            <div class="col-md-4 mb-4 property-card" 
                 data-title="{{ strtolower($property->title) }}" 
                 data-type="{{ strtolower($property->property_type) }}" 
                 data-city="{{ strtolower($property->city ?? '') }}">
              <div class="car-wrap rounded ftco-animate">
                <div class="img rounded d-flex align-items-end" 
                     style="background-image: url('{{ $property->main_image ? asset('storage/' . $property->main_image) : asset('user-template/images/house-placeholder.jpg') }}'); position: relative;">
                  @if($property->status === 'rented')
                    <span class="badge bg-warning text-dark" style="position: absolute; top: 10px; right: 10px;">Rented</span>
                  @endif
                </div>
                <div class="text">
                  <h2 class="mb-0"><a href="{{ route('house-detail', ['id' => $property->id]) }}">{{ $property->title }}</a></h2>
                  <div class="d-flex mb-3">
                    <span class="cat">{{ $property->property_type }}</span>
                    <p class="price ml-auto">${{ number_format($property->price, 2) }} <span>/month</span></p>
                  </div>
                  <p class="d-flex mb-0 d-block">
                    @auth
                      @if(Auth::user()->role === 'tenant' && $property->status === 'available')
                        <a href="{{ route('payment.form', $property->id) }}" class="btn btn-primary py-2 mr-1">Rent now</a>
                      @endif
                    @else
                      @if($property->status === 'available')
                        <a href="{{ route('login') }}" class="btn btn-primary py-2 mr-1">Login to Rent</a>
                      @endif
                    @endauth
                    <a href="{{ route('house-detail', ['id' => $property->id]) }}" class="btn btn-secondary py-2 ml-1">Details</a>
                  </p>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        @if($properties->isEmpty())
          <div class="col-12 text-center py-5 empty-state">
            <i class="fas fa-home fa-4x text-muted mb-4"></i>
            <h4>No properties match your search criteria</h4>
            <p class="text-muted">Try adjusting your filters or search term.</p>
          </div>
        @endif

        <div class="row mt-5">
          <div class="col text-center">
            <div class="block-27">
              @if($properties->lastPage() > 1)
                <ul style="display: flex; justify-content: center;">
                  <li>
                    @if($properties->onFirstPage())
                      <span><</span>
                    @else
                      <a href="{{ $properties->previousPageUrl() }}"><</a>
                    @endif
                  </li>
                  <li class="{{ $properties->currentPage() == 1 ? 'active' : '' }}">
                    @if($properties->currentPage() == 1)
                      <span>1</span>
                    @else
                      <a href="{{ $properties->url(1) }}">1</a>
                    @endif
                  </li>
                  @php
                    $currentPage = $properties->currentPage();
                    $lastPage = $properties->lastPage();
                    if ($currentPage <= 3) {
                      $startPage = 2;
                      $endPage = min($lastPage - 1, 5);
                    } elseif ($currentPage >= $lastPage - 2) {
                      $startPage = max(2, $lastPage - 4);
                      $endPage = $lastPage - 1;
                    } else {
                      $startPage = $currentPage - 2;
                      $endPage = $currentPage + 2;
                      if ($endPage >= $lastPage - 1) {
                        $endPage = $lastPage - 1;
                      }
                      if ($startPage <= 1) {
                        $startPage = 2;
                      }
                    }
                  @endphp
                  @if($startPage > 2)
                    <li><span class="ellipsis">...</span></li>
                  @endif
                  @for($i = $startPage; $i <= $endPage; $i++)
                    <li class="{{ $currentPage == $i ? 'active' : '' }}">
                      @if($currentPage == $i)
                        <span>{{ $i }}</span>
                      @else
                        <a href="{{ $properties->url($i) }}">{{ $i }}</a>
                      @endif
                    </li>
                  @endfor
                  @if($endPage < $lastPage - 1)
                    <li><span class="ellipsis">...</span></li>
                  @endif
                  @if($lastPage > 1)
                    <li class="{{ $currentPage == $lastPage ? 'active' : '' }}">
                      @if($currentPage == $lastPage)
                        <span>{{ $lastPage }}</span>
                      @else
                        <a href="{{ $properties->url($lastPage) }}">{{ $lastPage }}</a>
                      @endif
                    </li>
                  @endif
                  <li>
                    @if($properties->hasMorePages())
                      <a href="{{ $properties->nextPageUrl() }}">></a>
                    @else
                      <span>></span>
                    @endif
                  </li>
                </ul>
              @endif
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
                  <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                  <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                  <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <p>
              Copyright ©<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            </p>
          </div>
        </div>
      </div>
    </footer>

    <div id="ftco-loader" class="show fullscreen">
      <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
      </svg>
    </div>

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
    <script src="{{ asset('user-template/js/houses.js') }}"></script>
  </body>
</html>