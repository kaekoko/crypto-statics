$(function(){
    var token = $('#token').val();
    $('.update-custom').on('click', function(){
        var target = $(this).attr('data-id');
        var id = $(this).attr('id');
        var number = $('#' + target).val();
        $.ajax({
            url: 'manual/' + id,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
            },
            data:{
                number: number
            },
            success: function ( data ) {
              if(data.message == 'success'){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  })
                  
                  Toast.fire({
                    icon: 'success',
                    title: 'Number updated successfully'
                  })
              }
            }
        })
    })
})