<script>
    $(document).ready(() => {
        ajaxAddToCatalog();
    });

    window.loggedIn = {!! json_encode(auth()->user(), JSON_HEX_TAG) !!}
        console.log(loggedIn);

    function ajaxAddToCatalog() {
        $('.ad-add').each(function (el) {
            if (!loggedIn) {
                return;
            }
            $(this).on('click', function (ev) {
                ev.preventDefault();
                const offerId = $(this).data('offer-id');
                const type = $(this).data('type');
                const isInCatalog = $(this).find('i').text() === 'delete';
                const ajaxSettings = {
                    url: $(this).find('i').text() === 'delete' ? '/deletemycatalog' : '/addtomycatalog',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    type: 'GET',
                    success:  () => {
                        if ($(this).find('i').text() === 'add') {
                            $(this).find('i').text('delete');
                        } else {
                            $(this).find('i').text('add');
                        }
                    },
                    error: function () {
                        alert('error');
                    }
                };
                if (isInCatalog) {
                    ajaxSettings.data = {
                        idoffert: offerId
                    }
                } else {
                    ajaxSettings.data = {
                        id_offert: offerId,
                        type: type,
                    };
                }
                $.ajax(ajaxSettings);
            });
        });
    }
</script>
