$(document).ready(function() {
    // Initialize Owl Carousel
    $('.gallery-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    // Initialize Magnific Popup for carousel items
    $('.gallery-carousel').magnificPopup({
        delegate: 'a.magnific-popup',
        type: 'image',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        },
        image: {
            titleSrc: function(item) {
                return item.el.find('img').attr('alt');
            }
        },
        zoom: {
            enabled: true,
            duration: 300,
            opener: function(element) {
                return element.find('img');
            }
        }
    });
});


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    // Initialize Owl Carousel for gallery
    $('.gallery-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    // Initialize Magnific Popup for carousel items
    $('.gallery-carousel').magnificPopup({
        delegate: 'a.magnific-popup',
        type: 'image',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        },
        image: {
            titleSrc: function(item) {
                return item.el.find('img').attr('alt');
            }
        },
        zoom: {
            enabled: true,
            duration: 300,
            opener: function(element) {
                return element.find('img');
            }
        }
    });

    // Handle review submission
    $('.review-form').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Show SweetAlert for 2.5 seconds without confirm button
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Remove "No reviews" message if present
                $('#no-reviews').remove();

                // Append the new review
                let reviewHtml = `
                    <div class="review d-flex">
                        <div class="user-img" style="background-image: url('${response.review.user.profile_picture}')"></div>
                        <div class="desc">
                            <h4>
                                <span class="text-left">${response.review.user.name}</span>
                                <span class="text-right">${response.review.created_at}</span>
                            </h4>
                            <p class="star">
                                <span>
                                    ${Array(5).fill().map((_, i) => 
                                        `<i class="ion-ios-star ${i < response.review.rating ? '' : 'outline'}"></i>`
                                    ).join('')}
                                </span>
                            </p>
                            <p>${response.review.comment}</p>
                        </div>
                    </div>
                `;
                $('#reviews-container').append(reviewHtml);

                // Update review count
                let currentCount = parseInt($('.head').first().text().match(/\d+/)[0] || 0);
                $('.head').first().text(`${currentCount + 1} Reviews`);

                // Clear the form
                form[0].reset();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error || 'Something went wrong!',
                    timer: 2500,
                    showConfirmButton: false
                });
            }
        });
    });
});