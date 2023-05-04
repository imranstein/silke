<x-app-layout>
    <div>
        <div class="content">
            <div class="container-fluid">
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
                                        <p><strong>Email:</strong> {{ $contact->email }}</p>
                                        <p><strong>Phone:</strong> {{ $contact->phone }}</p>
                                        <p><strong>Alternate Phone:</strong> {{ $contact->alt_phone }}</p>
                                        <p><strong>Address:</strong> {{ $contact->address }}</p>
                                        <p><strong>Date Of Birth:</strong> {{ $contact->dob }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary mr-2">Share</button>
                                        <a href="{{ route('vcf', $contact->id) }}" class="btn btn-danger">Download VCF</a>
                                    </div>
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
