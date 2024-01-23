@extends('layouts.main')

@section('content')

<div class="card">
   

    <div class="card-body">
        <form method="POST" action="{{ route("passwordupdate") }}">
            @csrf
   
            <div class="form-group">
                <label class="required" for="title">New Password</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>
         
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                   save
                </button>
            </div>
        </form>
    </div>
</div>

@endsection