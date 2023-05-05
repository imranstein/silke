<x-app-layout>
    @section('title','Dashboard')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">phone</i>
                    </div>
                    <p class="card-category">Contacts</p>
                    <h3 class="card-title">{{ $contacts }}

                    </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">cake</i>
                    </div>
                    <p class="card-category">Today's Birthday</p>
                    <h3 class="card-title">{{ $birthdays }}</h3>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">cake</i>
                    </div>
                    <p class="card-category">Upcoming Birthdays</p>
                    <h3 class="card-title">{{ $upcomings->count() }}</h3>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4 class="card-title">Birthday's</h4>
                    <p class="card-category">
                        {{-- this week i wanna display the current week from and to --}}
                        @php

                        $from = Carbon\Carbon::today();
                        $to = Carbon\Carbon::today()->addDays(5);
                        @endphp

                        From {{ $from->format('d M Y') }} - {{ $to->format('d M Y') }}

                    </p>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="text-warning">
                            <th>Name</th>
                            <th>Birthday</th>
                            <th>Phone</th>
                        </thead>
                        <tbody>
                            @forelse ($upcomings as $birthday)
                            <tr>
                                <td>{{ $birthday->name }}</td>
                                <td>{{ date('l, F jS ', strtotime($birthday->dob)) }}</td>
                                <td><a href="tel:{{ $birthday->phone }}">{{ $birthday->phone }}</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No Upcoming Birthdays</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
