@extends('layouts.main')

@section('content')

<div class="col-md-12">
    <div class="form-group">
        <input type="time" name="section" class="form-control section-input" placeholder="Enter Section">
    </div>
    <div class="form-group mt-2">
        <button class="btn btn-success enter-section text-right">Add Section</button>
    </div>
</div>
<div class="col-md-12">
    <div class="row" id="getsections">
        @foreach($sections as $section)
            <div class="col-md-6 mt-2">
                <button class="btn btn-dark btn-block" disabled>{{ date('h:i A', strtotime($section->section)) }}</button>
                <form action="{{ route('delete_section', $section->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger btn-block mt-2">DELETE</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@section('script')
<script src="../js/section.js"></script>
@endsection
@endsection