<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Property Listing - Stay Haven</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
    <link rel="stylesheet" href="{{ asset('user-template/css/property-listing.css') }}">
    
    <!-- Additional CSS for the property listing -->
    <style>
    
    .badge-disapproved {
    background-color: #dc3545; /* Red background for disapproved */
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.9em;
}

  </style>
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
            @if(Auth::check() && Auth::user()->role === 'landlord')
              <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
              <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
              <li class="nav-item active"><a href="{{ route('property.listing') }}" class="nav-link">Property Listing</a></li>
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
            @endauth
          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->

    <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('user-template/images/propertylisting.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
          <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
              <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs"><span class="mr-2"><a href="{{ route ('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Property Listing <i class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-3 bread">Your Property Listings</h1>
              </div>
            </div>
          </div>
        </div>
    </section>
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
          <div class="col-md-12 heading-section text-center ftco-animate">
            <span class="subheading">Your Properties</span>
            <h2 class="mb-4">Manage Your Listings</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card shadow-sm">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Your Property Listings</h4>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPropertyModal">
                  <i class="fas fa-plus"></i> Add New Property
                </button>
              </div>

              <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif

                @if($properties->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-home fa-4x text-muted mb-4"></i>
                        <h4>No properties found</h4>
                        <p class="text-muted">You haven't listed any properties yet. Get started by adding your first property!</p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPropertyModal">
                            <i class="fas fa-plus"></i> Add Property
                        </button>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>Price</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($properties as $property)
                                    <tr>
                                        <td>
                                            @if($property->main_image)
                                                <img src="{{ asset('storage/' . $property->main_image) }}" alt="{{ $property->title }}" class="property-image rounded">
                                            @else
                                                <div class="property-placeholder rounded">
                                                    <i class="fas fa-home text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $property->title }}</td>
                                        <td>
                                            {{ $property->city }}, {{ $property->state }}<br>
                                            <small class="text-muted">{{ $property->address }}</small>
                                        </td>
                                        <td>${{ number_format($property->price, 2) }}/mo</td>
                                        <td>
                                            {{ $property->bedrooms }} BR / {{ $property->bathrooms }} BA<br>
                                            {{ number_format($property->square_feet) }} sqft
                                        </td>
                                        <td>
                                            @if($property->status === 'pending')
                                                <span class="badge badge-pending">Pending Approval</span>
                                            @elseif($property->status === 'available')
                                                <span class="badge badge-available">Available</span>
                                            @elseif($property->status === 'rented')
                                                <span class="badge badge-rented">Rented</span>
                                            @elseif($property->status === 'maintenance')
                                                <span class="badge badge-maintenance">Under Maintenance</span>
                                            @elseif($property->status === 'disapproved')
                                                <span class="badge badge-disapproved">Disapproved</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if($property->status !== 'disapproved')
                                                    <button class="btn btn-sm btn-primary edit-property mr-2" 
                                                            data-toggle="modal" 
                                                            data-target="#createPropertyModal"
                                                            data-edit="true"
                                                            data-id="{{ $property->id }}"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                                @if($property->status !== 'rented' && $property->status !== 'maintenance')
                                                    <button class="btn btn-sm btn-danger delete-property" 
                                                            data-id="{{ $property->id }}"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="pagination-container mt-4">
                            <div class="pagination-info">
                                Showing {{ $properties->firstItem() }} to {{ $properties->lastItem() }} of {{ $properties->total() }} results
                            </div>
                            <ul class="pagination">
                                <!-- Previous Page Link -->
                                @if($properties->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">«</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $properties->previousPageUrl() }}" rel="prev">«</a>
                                    </li>
                                @endif

                                <!-- Page Numbers -->
                                @foreach(range(1, $properties->lastPage()) as $i)
                                    @if($i >= $properties->currentPage() - 2 && $i <= $properties->currentPage() + 2)
                                        <li class="page-item {{ ($properties->currentPage() == $i) ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $properties->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                <!-- Next Page Link -->
                                @if($properties->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $properties->nextPageUrl() }}" rel="next">»</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">»</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>

<!-- Create Property Modal -->
<div class="modal fade" id="createPropertyModal" tabindex="-1" role="dialog" aria-labelledby="createPropertyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createPropertyModalLabel">Add New Property</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="createPropertyForm" action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="status" value="pending"> <!-- Default status for new properties -->
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="title">Property Title*</label>
                <input type="text" class="form-control" id="title" name="title" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="property_type">Property Type*</label>
                <select class="form-control" id="property_type" name="property_type" required>
                  <option value="">Select Type</option>
                  <option value="Apartment">Apartment</option>
                  <option value="House">House</option>
                  <option value="Condo">Condo</option>
                  <option value="Townhouse">Townhouse</option>
                  <option value="Duplex">Duplex</option>
                  <option value="Studio">Studio</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="description">Description*</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="address">Address*</label>
                <input type="text" class="form-control" id="address" name="address" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="city">City*</label>
                <input type="text" class="form-control" id="city" name="city" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="state">State*</label>
                <input type="text" class="form-control" id="state" name="state" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="zip_code">Zip Code*</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="price">Monthly Price ($)*</label>
                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="bedrooms">Bedrooms*</label>
                <input type="number" class="form-control" id="bedrooms" name="bedrooms" min="0" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="bathrooms">Bathrooms*</label>
                <input type="number" class="form-control" id="bathrooms" name="bathrooms" min="0" step="0.5" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="square_feet">Square Feet*</label>
                <input type="number" class="form-control" id="square_feet" name="square_feet" min="0" required>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Amenities (Check all that apply)</label>
            <div class="row">
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_parking" name="amenities[]" value="Parking">
                  <label class="form-check-label" for="amenity_parking">Parking</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_laundry" name="amenities[]" value="Laundry">
                  <label class="form-check-label" for="amenity_laundry">Laundry</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_gym" name="amenities[]" value="Gym">
                  <label class="form-check-label" for="amenity_gym">Gym</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_pool" name="amenities[]" value="Pool">
                  <label class="form-check-label" for="amenity_pool">Pool</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_pets" name="amenities[]" value="Pets Allowed">
                  <label class="form-check-label" for="amenity_pets">Pets Allowed</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_furnished" name="amenities[]" value="Furnished">
                  <label class="form-check-label" for="amenity_furnished">Furnished</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_wifi" name="amenities[]" value="WiFi">
                  <label class="form-check-label" for="amenity_wifi">WiFi</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_ac" name="amenities[]" value="Air Conditioning">
                  <label class="form-check-label" for="amenity_ac">Air Conditioning</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="amenity_heating" name="amenities[]" value="Heating">
                  <label class="form-check-label" for="amenity_heating">Heating</label>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="main_image">Main Image* (Max 10MB)</label>
                  <input type="file" class="form-control-file" id="main_image" name="main_image" accept="image/*" data-max-size="10240" required>
                  <small class="form-text text-muted">JPEG, PNG, or GIF (Max 10MB)</small>
                <div id="imagePreview" class="mt-2"></div>
              <div id="imageError" class="text-danger small mt-1"></div>
            </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="gallery_images">Gallery Images (Optional, max 5)</label>
                <input type="file" class="form-control-file" id="gallery_images" name="gallery_images[]" multiple accept="image/*">
                <small class="form-text text-muted">You can upload multiple images at once.</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Property</button>
        </div>
      </form>
    </div>
  </div>
</div>


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
                <li><a href="#" class="py-2 d-block">Privacy &amp; Cookies Policy</a></li>
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
              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved </a>
          </div>
        </div>
      </div>
    </footer>
    
  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('user-template/js/property-listing.js') }}"></script>

  
  <script>
 
</script>
    
  </body>
</html>