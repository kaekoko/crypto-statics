@extends('layouts.main')

@section('content')
<form action="{{ route('logs') }}">
    <input type="date" name="date" class="mt-2" value="{{ $date ? $date->format('Y-m-d') : today()->format('Y-m-d') }}">
    <button class="btn btn-success">Search</button>
</form>

@if(empty($data['file']))
<div class="mt-4">
    <pre class="pre-log">No Logs Found.</pre>
</div>
@else
<div>
    <div class="row text-center mt-3">
        <div class="col-md-6 text-right">
            <h5 class="log-head">Time: {{ $data['lastModified']->format('Y-m-d h:i A') }}</b></h5>
        </div>
        <div class="col-md-6">
            <h5 class="log-head">File Size: {{ round($data['size']) / 1024 }} KB</h5>
        </div>
    </div>
    <pre class="pre-log">{{ $data['file'] }}</pre>
</div>
@endif
@endsection