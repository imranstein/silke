<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card">
                <div class="card-body">

                    <div class="row">

                        <div class="col-lg-12 margin-tb">

                            <div class="pull-left">

                                <h2>Share</h2>

                            </div>



                        </div>

                    </div>


                    @if (count($errors) > 0)

                    <div class="alert alert-danger">

                        <strong>Whoops!</strong> There were some problems with your input.<br><br>

                        <ul>

                            @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                    @endif



                    {!! Form::open(array('route' => 'share.contact','method'=>'POST')) !!}

                    <div class="row">
                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Share To:</strong>

                                @foreach ($users as $user)
                                <input type="checkbox" name="toUsers[]" value="{{ $user->id }}"> {{ $user->name }}
                                @if ($loop->iteration % 10 == 0)
                                <br>
                                @endif
                                @endforeach

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>

                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
