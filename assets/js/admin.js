// Admin Dashboard JavaScript

$(document).ready(function() {
    // Thumbnail preview
    $('#filmThumbnail').on('input', function() {
        const url = $(this).val().trim();
        if (url) {
            $('#thumbnailPreview').show();
            $('#thumbnailPreviewImg').attr('src', url).on('error', function() {
                $(this).attr('src', 'https://via.placeholder.com/200x300/CCCCCC/666666?text=Invalid+URL');
            });
        } else {
            $('#thumbnailPreview').hide();
        }
    });
    
    // Auto-generate thumbnail preview when mood or title changes
    $('#filmMood, #filmTitle').on('change input', function() {
        const mood = $('#filmMood').val();
        const title = $('#filmTitle').val();
        const thumbnail = $('#filmThumbnail').val().trim();
        
        // Only show auto-generated preview if thumbnail is empty
        if (!thumbnail && mood && title) {
            // This is just for preview, actual generation happens on server
            $('#thumbnailPreview').show();
            $('#thumbnailPreviewImg').attr('src', 'https://via.placeholder.com/300x450/0f4c75/ffffff?text=' + encodeURIComponent(title.substring(0, 20)));
        }
    });

    // Film form submission
    $('#filmForm').on('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        let isValid = true;
        $('.form-control[required], .form-select[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            showToast('Silakan lengkapi semua field yang wajib diisi!', 'error');
            return;
        }
        
        const formData = $(this).serialize();
        const filmId = $('#filmId').val();
        const isEdit = filmId && filmId !== '';
        
        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');
        
        $.ajax({
            url: 'api_films.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                submitBtn.prop('disabled', false).html(originalText);
                if (response.success) {
                    showToast(response.message);
                    $('#filmModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                submitBtn.prop('disabled', false).html(originalText);
                showToast('Terjadi kesalahan saat menyimpan data: ' + error, 'error');
            }
        });
    });

    // Delete film
    window.deleteFilm = function(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus film ini?')) {
            return;
        }

        $.ajax({
            url: 'api_films.php?id=' + id,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showToast(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function() {
                showToast('Terjadi kesalahan saat menghapus data!', 'error');
            }
        });
    };

    // Open add modal
    window.openAddModal = function() {
        $('#modalTitleText').text('Tambah Film');
        $('#modalTitle i').removeClass('bi-pencil').addClass('bi-plus-circle');
        $('#filmForm')[0].reset();
        $('#filmId').val('');
        $('#thumbnailPreview').hide();
        // Clear any validation errors
        $('.form-control, .form-select').removeClass('is-invalid');
    };

    // Open edit modal
    window.openEditModal = function(film) {
        $('#modalTitleText').text('Edit Film');
        $('#modalTitle i').removeClass('bi-plus-circle').addClass('bi-pencil');
        
        // Populate form fields
        $('#filmId').val(film.id);
        $('#filmTitle').val(film.title || '');
        $('#filmThumbnail').val(film.thumbnail || '');
        $('#filmMood').val(film.mood || '');
        $('#filmEnergy').val(film.energy_level || 3);
        $('#filmPlatform').val(film.platform || '');
        $('#filmPlatformUrl').val(film.platform_url || '');
        $('#filmGenre').val(film.genre || '');
        $('#filmYear').val(film.year || '');
        $('#filmDescription').val(film.description || '');
        
        // Show thumbnail preview if available
        if (film.thumbnail && film.thumbnail.trim() !== '') {
            $('#thumbnailPreview').show();
            $('#thumbnailPreviewImg').attr('src', film.thumbnail);
        } else {
            $('#thumbnailPreview').hide();
        }
        
        // Clear validation errors
        $('.form-control, .form-select').removeClass('is-invalid');
        
        // Show modal
        $('#filmModal').modal('show');
    };

    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = $('#toastNotification');
        const toastMessage = $('#toastMessage');
        const toastHeader = toast.find('.toast-header');
        
        toastMessage.text(message);
        
        if (type === 'error') {
            toastHeader.find('i').removeClass('bi-check-circle-fill text-success')
                          .addClass('bi-exclamation-triangle-fill text-danger');
            toastHeader.find('strong').text('Error');
        } else {
            toastHeader.find('i').removeClass('bi-exclamation-triangle-fill text-danger')
                          .addClass('bi-check-circle-fill text-success');
            toastHeader.find('strong').text('Berhasil');
        }
        
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
    }

    // Reset modal on close
    $('#filmModal').on('hidden.bs.modal', function() {
        $('#filmForm')[0].reset();
        $('#thumbnailPreview').hide();
    });
});

