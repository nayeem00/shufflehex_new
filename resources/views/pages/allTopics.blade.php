@extends('layouts.master')
@section('css')
    <!-- Our Custom CSS -->
@endsection
@section('content')
@endsection
@section('js')
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="m-auto alert-box" style="max-width: 400px">
                <div class="alert alert-success">
                    <p>Email has been verified</p>
                </div>
                <div class="alert alert-warning">
                    <p>Email verification unsuccessfull</p>
                </div>
                <div class="alert alert-info">
                    <p>Link Expired</p>
                </div>
            </div>
        </div>
    </div>
@endsection