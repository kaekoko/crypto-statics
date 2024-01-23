@extends('layouts.main')

@section('content')
<div class="container" id="number-con">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                   <div class="row">
                       <div class="col-md-6 text-center">
                            <label class="label">Buy</label>
                            <div class="form-group mt-3">
                                <button class="btn btn-info num-dashboard buy"></button>
                            </div>
                       </div>
                       {{-- <div class="col-md-4 text-center">
                            <label class="label">Sell</label>
                            <div class="form-group mt-3">
                                <button class="btn btn-info num-dashboard sell"></button>
                            </div>
                       </div> --}}
                       <div class="col-md-6 text-center mt-2">
                            <label class="label">Number</label>
                            <div class="form-group mt-3">
                                <button class="btn btn-success num-dashboard number"></button>
                            </div>
                       </div>
                   </div>
                </div>
            </div>
            <div class="row" id="lists">
                
            </div>
        </div>
    </div>
</div>

<div class="container" id="close-con" hidden>
    <div class="col-md-12 text-center">
        <h1>Crypto Close Today</h1>
    </div>
</div>

@section('script')
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-database.js"></script>
<script>
      const firebaseConfig = {
        apiKey: "AIzaSyBzypNw6h62u-IOCnyBobMPfBVOzbeez_4",
        authDomain: "crypto-da28a.firebaseapp.com",
        databaseURL: "https://crypto-da28a-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "crypto-da28a",
        storageBucket: "crypto-da28a.appspot.com",
        messagingSenderId: "873556556575",
        appId: "1:873556556575:web:6dcf8f681a301bfb1bce2a",
        measurementId: "G-851JLKQ5K5"
    };

    const app = firebase.initializeApp(firebaseConfig);

    var database = firebase.database();

    database.ref("number/data").on('value', function(snapshot) {
    console.log(snapshot);
        if(snapshot.val()){
            var data = snapshot.val();
            $('.buy').text(data['buy']).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000);
            $('.sell').text(data['sell']).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000);
            $('.number').text(data['number']).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000);
        }
    });

    database.ref("list/data").on('value', function(snap) {
        if(snap.val()){
            var data = snap.val();
            var html = "";
            $.each(data, function(i,v){
               html += `<div class="col-md-4">
                    <div class="card text-center" id="card-list">
                        <div class="card-body">
                            <p class="p-time">`+ v['time'] +`</p>
                            <h1 class="p-2d">`+ v['2d'] +`</h1>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="h-price">Buy</h5>
                                    <h5 class="h-value">`+ v['buy'] +`</h5>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
               `;
            })

            $('#lists').html(html);
        }
    });

    $.ajax({
        url: 'api/offday',
        type: 'GET',
        success: function ( data ) {
            if(data.status == 1){
                $('#close-con').prop('hidden', false);
                $('#number-con').prop('hidden', true);
            }
        }
    })
</script>
@endsection
@endsection
