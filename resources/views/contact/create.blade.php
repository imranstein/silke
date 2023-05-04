@extends('layouts.components.form', ['activePage' => 'contact', 'titlePage' => __('Contact')])
@section('model','Contact')
@section('title','Contact')
@section('back',route('contacts'))
@section('type','Create')
@section('form')


<form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name</strong>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email</strong>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone</strong>
            <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Contact Number">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Alt Phone</strong>
            <input type="number" class="form-control" id="alt_phone" name="alt_phone" placeholder="Enter Alternative Number">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Address</strong>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Date Of Birth</strong>
            <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter DOB">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <strong>Profile Image</strong>
            <input type="file" class="form-control" id="image" name="image" placeholder="Enter Profile Image">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
