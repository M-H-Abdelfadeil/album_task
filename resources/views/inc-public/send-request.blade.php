<script>
    function sendRequest(url ,  method , data){
        $('button[type="submit"]').attr('disabled',true)
        $('.invalid-feedback').html(null)
        $('input').removeClass('is-invalid')

       

        $.ajax({
            url: url,
            method: method,
            data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res) {
                toastr.success(res.message)
                $('button[type="submit"]').attr('disabled',false)
                $('input[type="text"] , input[type="file"]').val(null)
            },
            error: function(error, status, type_error) {

                console.log(error)
                var message =error.responseJSON.message
                var errors = error.responseJSON.errors
                $.each(errors, function(key, val) {
                    $(`#${key}`).addClass('is-invalid');
                    $(`#msg-${key}`).html(val[0])
                })

                toastr.error(error.status+"<br>"+error.statusText)
                $('button[type="submit"]').attr('disabled',false)
            }
        })
    }
</script>
