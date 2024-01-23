$(function(){
    var token = $('#token').val();
    $('.offday').on('click', function(e){
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#e5587a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete-offday/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                    },
                    success: function ( data ) {
                        if(data.message == "success"){
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                              )
                              $('#off-'+id).remove();
                        }
                    }
                });
            }
          })
    })
})