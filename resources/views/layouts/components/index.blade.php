{{-- @extends('layouts.app', ['activePage' => 'user', 'titlePage' => __('User')])

@section('content')
 --}}
{{-- @section('title','') --}}
<x-app-layout>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">


                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">people</i>
                                </div>
                                <p class="card-category">@yield('title')</p>
                                <h3 class="card-title">{{ $count }}</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">date_range</i> Last 1 year
                                </div>
                            </div>

                        </div>
                    </div>
                    @if (session()->has('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span>
                            <b> </b> {{ session('success') }} </span>

                    </div>
                    @endif

                    @if (session()->has('delete'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span>
                            {{ session('delete') }}</span>

                    </div>
                    @endif
                    @if (session()->has('update'))
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span>
                            {{ session('update') }}</span>

                    </div>
                    @endif

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">@yield('title')</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <a href="@yield('route')" class="btn btn-sm btn-success">Add @yield('insert')</a>
                                    </div>


                                </div>
                                <div class="table-responsive">
                                    {{-- contains content --}}
                                    @yield('content')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- @endsection --}}
