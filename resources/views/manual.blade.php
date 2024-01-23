@extends('layouts.main')

@section('content')

    <div class="col-md-12 text-center">
        @foreach($customs as $custom)
        <div class="row mt-2">
            <div class="col-md-4">
                <button class="btn btn-info">{{ $custom->record_time }}</button>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control mt-2" id="input-{{ $custom->id }}" value="{{ $custom->number }}">
            </div>
            <div class="col-md-4">
                <button class="btn btn-info update-custom" id="{{ $custom->id }}" data-id="input-{{ $custom->id }}">Update</button>
            </div>
        </div>
        @endforeach
    </div>
    

@section('script')
<script src="../js/manual.js"></script>
@endsection
@endsection