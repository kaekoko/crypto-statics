@extends('layouts.main')

@section('content')

    <form action="{{ route('create-offdays') }}" method="POST">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success">Add Offday</button>
            </div>
        </div>
    </form>
<div class="row mt-2">
    @foreach($offdays as $off)
        <div class="col mt-2" id="off-{{ $off->id }}">
            <span class="badge bg-danger offday" data-id="{{ $off->id }}">{{ $off->date }}, {{ $off->day }}</p>
        </div>
    @endforeach
</div>

@section('script')
<script src="../js/offday.js"></script>
@endsection
@endsection