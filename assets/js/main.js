// Energy Level Slider Update
$(document).ready(function() {
    // Update energy level display
    $('#energyLevel').on('input', function() {
        $('#energyValue').text($(this).val());
    });

    // Share button functionality
    $(document).on('click', '.share-btn', function() {
        const title = $(this).data('title');
        const url = $(this).data('url');
        const shareText = `Tonton "${title}" di: ${url}`;
        
        // Copy to clipboard
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(shareText).then(function() {
                showToast('Link film berhasil disalin ke clipboard!');
            }).catch(function() {
                fallbackCopyTextToClipboard(shareText);
            });
        } else {
            fallbackCopyTextToClipboard(shareText);
        }
    });

    // Fallback copy function for older browsers
    function fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showToast('Link film berhasil disalin ke clipboard!');
            } else {
                showToast('Gagal menyalin link. Silakan salin manual: ' + text, 'error');
            }
        } catch (err) {
            showToast('Gagal menyalin link. Silakan salin manual: ' + text, 'error');
        }
        
        document.body.removeChild(textArea);
    }

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

    // Form validation
    $('#moodForm').on('submit', function(e) {
        const mood = $('input[name="mood"]:checked').val();
        const platform = $('select[name="platform"]').val();
        
        if (!mood) {
            e.preventDefault();
            showToast('Silakan pilih mood Anda!', 'error');
            return false;
        }
        
        if (!platform) {
            e.preventDefault();
            showToast('Silakan pilih platform preferensi!', 'error');
            return false;
        }
    });

    // Animate cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe film cards
    document.querySelectorAll('.film-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
});

