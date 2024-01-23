$(function(){
    var token = $('#token').val();
    $('.enter-section').on('click', function(){
        var section = $('.section-input').val();
        $.ajax({
            url: 'section',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
            },
            data:{
                section:section
            },
            success: function ( data ) {
                if(data.message == 'success'){
                    $('#getsections').append(`
                        <div class="col-md-6 mt-2">
                            <button class="btn btn-dark" disabled>`+ data.data +`</button>
                            <button class="btn btn-danger btn-block">DELETE</button>
                        </div>
                    `)
                }
            }
        })
    })
})