<x-app-layout>
    <div>
        <div class="content">
            <div class="container-fluid">
                @include('contact.share')
                <div class="row">
                    <div class="card">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset($contact->image) }}" alt="Profile Picture" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="col-md-6">
                                        <h2>{{ $contact->name }}</h2>
                                        <p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                                        <p><strong>Phone:</strong><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></p>
                                        <p><strong>Alternate Phone:</strong> <a href="tel:{{ $contact->alt_phone }}">{{ $contact->alt_phone }}</a></p>
                                        <p><strong>Address:</strong> {{ $contact->address }}</p>
                                        <p><strong>Date Of Birth:</strong> {{ $contact->dob }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <a class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Share</a>
                                        <a href="{{ route('vcf', $contact->id) }}" class="btn btn-danger">Download VCF</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="map" class="col-8"></div>

                </div>
            </div>
        </div>
    </div>
    @section('script')
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                   lat: {{ $contact->latitude }},
                   lng: {{ $contact->longitude }}
                }
                , zoom: 8
            });

            var marker = new google.maps.Marker({
                position: {
                    lat: {{ $contact->latitude }},
                    lng: {{ $contact->longitude }}
                }
                , map: map
                , title: '{{ $contact->name }}'
            });

            // Get your current location using the Geolocation API
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var myLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                    // Get directions from your location to the marker's location
                    var directionsService = new google.maps.DirectionsService();
                    var directionsRenderer = new google.maps.DirectionsRenderer();
                    directionsRenderer.setMap(map);

                    var request = {
                        origin: myLocation
                        , destination: marker.getPosition()
                        , travelMode: google.maps.TravelMode.DRIVING
                    };

                    directionsService.route(request, function(result, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsRenderer.setDirections(result);
                        }
                    });
                });
            }
        }

        // Wait for the Google Maps API to load before calling initMap()
        $(document).ready(function() {
            if (typeof google !== 'undefined') {
                google.maps.event.addDomListener(window, 'load', initMap);
            }
        });

    </script>
    @endsection
</x-app-layout>
{{-- @endsection --}}
