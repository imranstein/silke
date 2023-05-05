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

                        <div id="map"></div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- @endsection --}}
@section('script')
<script>
    function initMap() {
        // Define map options
        var mapOptions = {
            center: {
                lat: {{  $contact -> latitude }}
                , lng: {{ $contact -> longitude }}
            }
            , zoom: 8
        };

        // Create a new map object
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Add a marker to the map
        var marker = new google.maps.Marker({
            position: {
                lat: {{  $contact -> latitude }}
                , lng: {{  $contact -> longitude }}
            }
            , map: map
            , title: "{{ $contact->name }}"
        });
    }

</script>
@endsection
