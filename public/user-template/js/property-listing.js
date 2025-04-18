   
$(document).ready(function() {
    // Image preview and validation
    $('#main_image').change(function() {
        const file = this.files[0];
        const maxSize = 10240; // 10MB in KB
        const errorElement = $('#imageError');
        
        errorElement.text(''); // Clear previous errors
        
        if (file) {
            // Check file size
            if (file.size > maxSize * 1024) {
                errorElement.text('File size must be less than 10MB');
                $(this).val(''); // Clear the file input
                $('#imagePreview').empty();
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').html(`<img src="${e.target.result}" class="img-fluid image-preview rounded" alt="Preview">`);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#createPropertyModal').on('show.bs.modal', function(e) {
      const modal = $(this);
      const isEdit = $(e.relatedTarget).data('edit');
      const propertyId = $(e.relatedTarget).data('id');

      // Reset form and clear any previous data
      modal.find('form')[0].reset();
      $('#imagePreview').empty();
      $('#imageError').empty();
      $('.is-invalid').removeClass('is-invalid');
      $('.invalid-feedback').remove();
      $('input[name="amenities[]"]').prop('checked', false);

      // Remove required attribute for edit mode
      if (isEdit && propertyId) {
          $('#main_image').removeAttr('required');
      } else {
          $('#main_image').attr('required', 'required');
      }

      if (isEdit && propertyId) {
          // Load property data for editing
          modal.find('.modal-title').text('Edit Property');
          modal.find('form').attr('action', `/property/update/${propertyId}`);
          modal.find('input[name="_method"]').val('PUT');
          $.get(`/property/edit/${propertyId}`, function(data) {
              // Fill form with property data
              modal.find('#title').val(data.title);
              modal.find('#property_type').val(data.property_type);
              modal.find('#description').val(data.description);
              modal.find('#address').val(data.address);
              modal.find('#city').val(data.city);
              modal.find('#state').val(data.state);
              modal.find('#zip_code').val(data.zip_code);
              modal.find('#price').val(data.price);
              modal.find('#bedrooms').val(data.bedrooms);
              modal.find('#bathrooms').val(data.bathrooms);
              modal.find('#square_feet').val(data.square_feet);
              modal.find('#available_from').val(data.available_from);

              // Handle status-specific logic
              if (data.status === 'rented' || data.status === 'maintenance') {
                  // Disable all fields except status
                  modal.find('input, select, textarea').not('#status').prop('disabled', true);

                  // Add status dropdown
                  const statusHtml = `
                      <div class="form-group">
                          <label for="status">Status*</label>
                          <select class="form-control" id="status" name="status" required>
                              <option value="rented" ${data.status === 'rented' ? 'selected' : ''}>Rented</option>
                              <option value="maintenance" ${data.status === 'maintenance' ? 'selected' : ''}>Under Maintenance</option>
                          </select>
                      </div>
                  `;
                  $('.form-group:has(label:contains("Amenities"))').before(statusHtml);
              } else {
                  // Enable all fields for other statuses
                  modal.find('input, select, textarea').prop('disabled', false);

                  // Keep status hidden for non-rented/maintenance properties
                  $('<input>').attr({
                      type: 'hidden',
                      name: 'status',
                      value: data.status
                  }).appendTo(modal.find('form'));
              }

              // Show current main image if exists
              if (data.main_image) {
                  $('#imagePreview').html(
                      `<img src="/storage/${data.main_image}" class="img-fluid image-preview rounded" alt="Current Image">
                      <small class="text-muted d-block">Current image</small>`
                  );
              }

              // Set amenities checkboxes
              if (data.amenities) {
                  const amenities = JSON.parse(data.amenities);
                  amenities.forEach(amenity => {
                      $(`input[name="amenities[]"][value="${amenity}"]`).prop('checked', true);
                  });
              }
          });
      } else {
          // Set up for creating new property
          modal.find('.modal-title').text('Add New Property');
          modal.find('form').attr('action', '/property/store');
          modal.find('input[name="_method"]').val('POST');
      }
  });

    // Form submission handler (for both create and update)
    $('#createPropertyForm').submit(function(e) {
        e.preventDefault();
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        // Get form data
        var formData = new FormData(this);
        // Add method for PUT requests
        if ($(this).attr('action').includes('update')) {
            formData.append('_method', 'PUT');
        }
        // Add AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Submit form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#createPropertyModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Operation completed successfully!',
                        showConfirmButton: false,
                        timer: 1000
                    }).then(() => {
                        // Refresh the page after successful update or creation
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var element = $('[name="' + key + '"]');
                        element.addClass('is-invalid');
                        element.after('<div class="invalid-feedback">' + value[0] + '</div>');
                    });
                } else {
                    console.error(xhr);
                    showAlert('danger', 'An error occurred. Please check console for details.');
                }
            }
        });
    });
    
    function updatePropertyTable(property, isNew) {
    const isEmptyState = $('.table-responsive').length === 0;

    // If there's no table structure yet, create one
    if (isEmptyState) {
        createTableStructure();
    }

    // Determine the status badge based on the property's status
    let statusBadge;
    if (property.status === 'pending') {
        statusBadge = '<span class="badge badge-pending">Pending Approval</span>';
    } else if (property.status === 'available') {
        statusBadge = '<span class="badge badge-available">Available</span>';
    } else if (property.status === 'rented') {
        statusBadge = '<span class="badge badge-rented">Rented</span>';
    } else if (property.status === 'maintenance') {
        statusBadge = '<span class="badge badge-maintenance">Under Maintenance</span>';
    }

    // Determine the image cell content (main image or placeholder)
    const imageCell = property.main_image
        ? `<img src="/storage/${property.main_image}" alt="${property.title}" class="property-image rounded">`
        : `<div class="property-placeholder rounded"><i class="fas fa-home text-muted"></i></div>`;

    // Determine the actions column content (edit and delete buttons)
    const actions = `
        <div class="btn-group" role="group">
            <button class="btn btn-sm btn-primary edit-property mr-2" 
                    data-toggle="modal" 
                    data-target="#createPropertyModal"
                    data-edit="true"
                    data-id="${property.id}"
                    title="Edit">
                <i class="fas fa-edit"></i>
            </button>
            ${(property.status !== 'rented' && property.status !== 'maintenance') ? 
                `<button class="btn btn-sm btn-danger delete-property" 
                        data-id="${property.id}"
                        title="Delete">
                    <i class="fas fa-trash"></i>
                </button>` : ''}
        </div>
    `;

    // Create the HTML for the updated table row
    const newRow = `
        <tr data-id="${property.id}">
            <td>${imageCell}</td>
            <td>${property.title}</td>
            <td>
                ${property.city}, ${property.state}<br>
                <small class="text-muted">${property.address}</small>
            </td>
            <td>$${parseFloat(property.price).toFixed(2)}/mo</td>
            <td>
                ${property.bedrooms} BR / ${property.bathrooms} BA<br>
                ${property.square_feet} sqft
            </td>
            <td>${statusBadge}</td>
            <td>${actions}</td>
        </tr>
    `;

    // If this is a new property, prepend it to the table
    if (isNew) {
        $('table tbody').prepend(newRow);
    } else {
        // Otherwise, replace the existing row with the updated data
        $(`tr[data-id="${property.id}"]`).replaceWith(newRow);
    }
}
    
    function createTableStructure() {
        const tableHtml = `
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
                    <tbody></tbody>
                </table>
            </div>
        `;
        
        $('.card-body').html(tableHtml);
    }
    
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        $('.alert').remove();
        
        $('.card-body').prepend(alertHtml);
        
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
    }
    
    $('#createPropertyModal').on('hidden.bs.modal', function() {
        $('#createPropertyForm')[0].reset();
        $('#imagePreview').empty();
        $('#imageError').empty();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('input[name="amenities[]"]').prop('checked', false);
        
        $('#status').closest('.form-group').remove();
        
        $('#createPropertyForm').attr('action', '/property/store');
        $('input[name="_method"]').val('POST');
        $('#main_image').attr('required', 'required');
    });
});

  // Delete property with SweetAlert confirmation
  $(document).on('click', '.delete-property', function(e) {
      e.preventDefault();
      const propertyId = $(this).data('id');
      const propertyRow = $(this).closest('tr');
      
      Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  url: `/property/delete/${propertyId}`,
                  type: 'POST',
                  data: {
                      _method: 'DELETE',
                      _token: $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response) {
                      if (response.success) {
                          propertyRow.remove();
                          
                          // If no properties left, show empty state
                          if ($('table tbody tr').length === 0) {
                              showEmptyState();
                          }
                          
                          Swal.fire(
                              'Deleted!',
                              'Your property has been deleted.',
                              'success'
                          );
                      }
                  },
                  error: function(xhr) {
                      Swal.fire(
                          'Error!',
                          'Failed to delete property.',
                          'error'
                      );
                  }
              });
          }
      });
  });

  function showEmptyState() {
      const emptyStateHtml = `
          <div class="text-center py-5">
              <i class="fas fa-home fa-4x text-muted mb-4"></i>
              <h4>No properties found</h4>
              <p class="text-muted">You haven't listed any properties yet. Get started by adding your first property!</p>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPropertyModal">
                  <i class="fas fa-plus"></i> Add Property
              </button>
          </div>
      `;
      
      $('.card-body').html(emptyStateHtml);
  }