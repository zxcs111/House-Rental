<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stay Haven - {{ $property->title }}</title>
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
    <link rel="stylesheet" href="{{ asset('user-template/css/house-detail.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                          <li class="nav-item"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
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
                              <a class="dropdown-item" href="{{ route('messages.index') }}" >Messages</a>
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
                      <li class="nav-item"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
                      <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                      <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                  @endauth
              </ul>
          </div>
      </div>
    </nav>

    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ $property->main_image ? asset('storage/' . $property->main_image) : asset('user-template/images/house-detail.jpg') }}');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
            <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>House Details <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">{{ $property->title }}</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-car-details">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="car-details">
              <div class="img rounded" style="background-image: url('{{ $property->main_image ? asset('storage/' . $property->main_image) : asset('user-template/images/bg_1.jpg') }}');"></div>
              <div class="text text-center">
                <span class="subheading" style="font-size: 1em">{{ $property->property_type }}</span>
                <h2>{{ $property->title }}</h2>
                <p class="location" style="font-size: 1.2em; line-height: 1.5;">
                  <span style="margin-left: 5px;">{{ $property->address }}, {{ $property->city }}, {{ $property->zip_code }}</span>
                </p>                    
                <div class="rent-button mt-4">  
                  <p class="d-flex mb-0 d-block justify-content-center">
                    @auth
                      @if(Auth::user()->role === 'tenant')
                        @php
                          $hasRented = App\Models\Payment::where('tenant_id', Auth::id())
                              ->where('property_id', $property->id)
                              ->where('status', 'completed')
                              ->exists();
                        @endphp
                        @if($hasRented)
                          <a href="{{ route('profile') }}" class="btn btn-primary py-2 mr-1">View Rental Details</a>
                        @else
                          <a href="{{ route('payment.form', $property->id) }}" class="btn btn-primary py-2 mr-1">Rent now</a>
                        @endif
                      @endif
                    @else
                      <a href="{{ route('login') }}" class="btn btn-primary py-2 mr-1">Login to Rent</a>
                    @endauth
                    <a href="{{ route('houses') }}" class="btn btn-secondary py-2 ml-1">Back to Houses</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
                <div class="d-flex mb-3 align-items-center">
                  <div class="icon d-flex align-items-center justify-content-center"><span class="fas fa-bed"></span></div>
                  <div class="text">
                    <h3 class="heading mb-0 pl-3">
                      Bedrooms
                      <span>{{ $property->bedrooms }}</span>
                    </h3>
                  </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
                <div class="d-flex mb-3 align-items-center">
                  <div class="icon d-flex align-items-center justify-content-center"><span class="fas fa-bath"></span></div>
                  <div class="text">
                    <h3 class="heading mb-0 pl-3">
                      Bathrooms
                      <span>{{ $property->bathrooms }}</span>
                    </h3>
                  </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
                <div class="d-flex mb-3 align-items-center">
                  <div class="icon d-flex align-items-center justify-content-center"><span class="fas fa-ruler-combined"></span></div>
                  <div class="text">
                    <h3 class="heading mb-0 pl-3">
                      Area
                      <span>{{ number_format($property->square_feet) }} sqft</span>
                    </h3>
                  </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
                <div class="d-flex mb-3 align-items-center">
                  <div class="icon d-flex align-items-center justify-content-center"><span class="fas fa-home"></span></div>
                  <div class="text">
                    <h3 class="heading mb-0 pl-3">
                      Type
                      <span>{{ $property->property_type }}</span>
                    </h3>
                  </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
                <div class="d-flex mb-3 align-items-center">
                  <div class="icon d-flex align-items-center justify-content-center"><span class="fas fa-dollar-sign"></span></div>
                  <div class="text">
                    <h3 class="heading mb-0 pl-3">
                      Price
                      <span>${{ number_format($property->price, 2) }}/mo</span>
                    </h3>
                  </div>
                </div>
              </div>
            </div>      
          </div>
        </div>

        <div class="row justify-content-center mt-5">
          <div class="col-md-12">
            <h3 class="mb-4 text-center">Property Pictures</h3>
            @if($property->gallery_images)
              <div class="gallery-carousel owl-carousel">
                @foreach(json_decode($property->gallery_images) as $image)
                  <a href="{{ asset('storage/' . $image) }}" class="gallery-item magnific-popup">
                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" class="img-fluid">
                  </a>
                @endforeach
              </div>
            @else
              <p class="text-center text-muted">No gallery images available for this property.</p>
            @endif
          </div>
        </div>

        <div class="container">
          <div class="row justify-content-center">
            <div class="property-owner">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Property Owner</h3>
              </div>
              <div class="d-flex align-items-center">
                @if($property->user->profile_picture)
                  <img src="{{ asset('storage/' . $property->user->profile_picture) }}" 
                      alt="Owner Profile" 
                      class="rounded-circle mr-4" 
                      style="width: 80px; height: 80px; object-fit: cover;">
                @else
                  <div class="rounded-circle mr-4 bg-secondary d-flex align-items-center justify-content-center" 
                      style="width: 80px; height: 80px;">
                    <i class="fas fa-user fa-2x text-white"></i>
                  </div>
                @endif
                <div>
                  <h4 class="mb-1">{{ $property->user->name }}</h4>
                  <p class="mb-2 text-muted">
                    <i class="fas fa-home mr-2"></i> Landlord
                  </p>
                  @auth
                    @if(Auth::user()->role === 'tenant')
                      <a href="{{ route('messages.conversation', $property->user->id) }}?property_id={{ $property->id }}" 
                        class="btn btn-primary">
                        Message Owner
                      </a>
                    @elseif(Auth::user()->id === $property->user_id)
                      <a href="{{ route('messages.index') }}" class="btn btn-primary">
                        View Messages
                      </a>
                    @endif
                  @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                      Login to Message
                    </a>
                  @endauth
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 pills">
            <div class="bd-example bd-example-tabs">
              <div class="d-flex justify-content-center">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Features</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-manufacturer-tab" data-toggle="pill" href="#pills-manufacturer" role="tab" aria-controls="pills-manufacturer" aria-expanded="true">Description</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-expanded="true">Review</a>
                  </li>
                </ul>
              </div>

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                  <div class="row">
                    <div class="col-md-4">
                      <ul class="features">
                        @foreach($property->amenities ? json_decode($property->amenities) : [] as $index => $amenity)
                          @if($index % 3 == 0)
                            <li class="check"><span class="ion-ios-checkmark"></span>{{ $amenity }}</li>
                          @endif
                        @endforeach
                      </ul>
                    </div>
                    <div class="col-md-4">
                      <ul class="features">
                        @foreach($property->amenities ? json_decode($property->amenities) : [] as $index => $amenity)
                          @if($index % 3 == 1)
                            <li class="check"><span class="ion-ios-checkmark"></span>{{ $amenity }}</li>
                          @endif
                        @endforeach
                      </ul>
                    </div>
                    <div class="col-md-4">
                      <ul class="features">
                        @foreach($property->amenities ? json_decode($property->amenities) : [] as $index => $amenity)
                          @if($index % 3 == 2)
                            <li class="check"><span class="ion-ios-checkmark"></span>{{ $amenity }}</li>
                          @endif
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="pills-manufacturer" role="tabpanel" aria-labelledby="pills-manufacturer-tab">
                  <p>{{ $property->description }}</p>
                </div>

                <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                  <div class="row">
                    <div class="col-md-7">
                      <h3 class="head">{{ $reviews->count() }} Reviews</h3>
                      <div id="reviews-container">
                        @forelse($reviews as $review)
                          <div class="review d-flex">
                            <div class="user-img" style="background-image: url('{{ $review->user->profile_picture ? asset('storage/' . $review->user->profile_picture) : asset('user-template/images/person_1.jpg') }}')"></div>
                            <div class="desc">
                              <h4>
                                <span class="text-left">{{ $review->user->name }}</span>
                                <span class="text-right">{{ $review->created_at->format('d M Y') }}</span>
                              </h4>
                              <p class="star">
                                <span>
                                  @for($i = 1; $i <= 5; $i++)
                                    <i class="ion-ios-star {{ $i <= $review->rating ? '' : 'outline' }}"></i>
                                  @endfor
                                </span>
                              </p>
                              <p>{{ $review->comment }}</p>
                            </div>
                          </div>
                        @empty
                          <p class="text-muted" id="no-reviews">No reviews yet. Be the first to leave a review!</p>
                        @endforelse
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="rating-wrap">
                        <h3 class="head">Give a Review</h3>
                        @auth
                          @if(Auth::user()->role === 'tenant')
                            @php
                              $hasPaid = App\Models\Payment::where('tenant_id', Auth::id())
                                  ->where('property_id', $property->id)
                                  ->where('status', 'completed')
                                  ->exists();
                            @endphp
                            @if($hasPaid)
                              <form action="{{ route('reviews.store', $property->id) }}" method="POST" class="review-form">
                                @csrf
                                <div class="form-group">
                                  <label for="rating">Rating</label>
                                  <select name="rating" id="rating" class="form-control" required>
                                    <option value="">Select Rating</option>
                                    <option value="5">5 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="2">2 Stars</option>
                                    <option value="1">1 Star</option>
                                  </select>
                                  @error('rating')
                                    <span class="text-danger">{{ $message }}</span>
                                  @enderror
                                </div>
                                <div class="form-group">
                                  <label for="comment">Your Review</label>
                                  <textarea name="comment" id="comment" class="form-control" rows="5" placeholder="Write your review here..." required></textarea>
                                  @error('comment')
                                    <span class="text-danger">{{ $message }}</span>
                                  @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                              </form>
                            @else
                              <p class="text-muted">You must rent this property to leave a review.</p>
                            @endif
                          @else
                            <p class="text-muted">Only tenants can leave reviews for this property.</p>
                          @endif
                        @else
                          <p class="text-muted">Please <a href="{{ route('login') }}">log in</a> to leave a review.</p>
                        @endauth
                      </div>
                    </div>
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
    
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

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
    <script src="{{ asset('user-template/js/house-detail-carousel.js') }}"></script>
    
  </body>
</html>