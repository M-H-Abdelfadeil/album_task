@include('inc-public.send-request')
<script>
    function add_new_image() {
        // get count images

        var count_images = +$('#count-images').val();

        var arr_numbers = $('#arr_numbers').val().split(",");
        arr_numbers.push(count_images + 1)
        $('#arr_numbers').val(arr_numbers)


        //plus count images +1
        $('#count-images').val(count_images + 1)

        $('#container-image').append(`
            <div class="form-group border border-dark p-3 num-${count_images+1}">
                <button type="button" data-number="${count_images+1}"  class="btn btn-danger fa fa-times circle close-image"></button>
                <div class="row">
                    <div class="col-6">
                        <div>
                            <label for="image_0">Image</label>
                            <input type="file" name="image_${count_images+1}"  class="form-control" id="image_${count_images+1}">
                            <div class="invalid-feedback" id="msg-image_${count_images+1}"> </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <label for="name_${count_images+1}">Image name</label>
                            <input type="text" name="image_name_${count_images+1}" class="form-control" id="image_name_${count_images+1}" placeholder="Name">
                            <div class="invalid-feedback" id="msg-image_name_${count_images+1}"> </div>
                        </div>
                    </div>
                </div>
            </div>
            `)

    }


    $(function() {


        $('#btn-add-image').click(function() {

                add_new_image()
        })

        $(document).on('click', '.close-image', function() {
            var number = $(this).data('number');
            $(`.num-${number}`).remove()

            var arr_numbers = $('#arr_numbers').val().split(",");
            var new_arr_numbers = [];
            $.each(arr_numbers, function(key, val) {
                if (val != number) {
                    new_arr_numbers.push(val)
                }
            })
            $('#arr_numbers').val(new_arr_numbers)
        })


        $('#form-create-album').submit(function(e) {
            e.preventDefault();

            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var data = new FormData(this);

            sendRequest(url ,  method , data)
        })




    })
</script>
