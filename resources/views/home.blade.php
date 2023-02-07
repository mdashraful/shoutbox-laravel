@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
        
    <div class="row justify-content-center" style="margin-top: 20px;">
        <a href="{{ route('shout') }}" role="button" class="btn btn-primary btn-lg btn-block">Go For Shout</a> 
    </div>
</div>
@endsection
