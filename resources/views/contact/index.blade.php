@section('title','Contact')
<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
                <span>
                    <b> </b> {{ session('message') }} </span>

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



            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Contact</h4>
                            <p class="card-category"> Here you can manage Contact</p>

                        </div>

                        <div class="card-body">
                            <div class="row">


                                @can('contact-list')
                                <div class="col-12 text-right">
                                    <div class=" col-md-4" style="width:25%; float: right;">
                                        <input type="search" wire:model.debounce.500ms="search" class="form-control" placeholder="Search by name,email,phone,or address...">
                                    </div>

                                    <div class="d-flex align-items-center ml-4">
                                        <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                                            <form action="{{ route('contact.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="file" class="form-control">
                                                <button class="btn btn-sm btn-success" style="text-align: right;">Import Contacts</button>
                                            </form>
                                        </div>

                                        <label for="paginate" class="text-nowrap mr-2 mb-0" style="color:black;">Per Page</label>
                                        <select wire:model="paginate" name="paginate" id="paginate" class="form-control form-control-sm" style="width:5%;">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>


                                        </select>
                                        <div>
                                            @if ($checked)
                                            <div class="dropdown ml-4">
                                                <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">With Checked
                                                    ({{ count($checked) }})</button>
                                                <div class="dropdown-menu">
                                                    <a href="#" class="dropdown-item" type="button" onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()" wire:click="deleteRecords()">
                                                        Delete
                                                    </a>
                                                    <a href="#" class="dropdown-item" type="button" onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="exportSelected()">
                                                        CSV
                                                    </a>
                                                    <a href="#" class="dropdown-item" type="button" onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="excelSelected()">
                                                        Excel
                                                    </a>
                                                </div>
                                            </div>
                                            @endif



                                        </div>
                                        <div class="dropdown ml-4">
                                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Columns
                                            </button>
                                            <div class="dropdown-menu">
                                                @foreach($columns as $column)
                                                <li><input type="checkbox" wire:model="selectedColumns" value="{{$column}}">
                                                    <label style="color:black;font-size:12px:">{{$column}}</label></li>
                                                @endforeach


                                            </div>
                                        </div>


                                    </div>


                                    @can('contact-create')

                                    <a href="{{ route('contact.create') }}" class="btn btn-sm btn-success">Add Contact</a>
                                    @endcan

                                </div>


                            </div>
                            @if ($selectPage)
                            <div class="col-md-10 mb-2">
                                @if ($selectAll)
                                <div>
                                    You have selected all <strong>{{ $contacts->total() }}</strong> items.
                                </div>
                                @else
                                <div>
                                    You have selected <strong>{{ count($checked) }}</strong> items,
                                </div>
                                @endif

                            </div>
                            @endif

                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped table-sortable">

                                    <thead class=" text-primary">

                                        <tr>

                                            <th><input type="checkbox" wire:model="selectPage"></th>
                                            @if($this->showColumn('Id'))
                                            <th>ID <i class="fa fa-fw fa-sort" wire:click="sortBy('id')"></i>
                                            </th>

                                            @endif
                                            @if($this->showColumn('Name'))
                                            <th>Name <i class="fa fa-fw fa-sort" wire:click="sortBy('name')"></i></th>
                                            @endif
                                            @if($this->showColumn('Email'))
                                            <th>Email <i class="fa fa-fw fa-sort" wire:click="sortBy('email')"></i></th>
                                            @endif
                                            @if($this->showColumn('Phone'))
                                            <th>Phone <i class="fa fa-fw fa-sort" wire:click="sortBy('phone')"></i></th>
                                            @endif
                                            @if($this->showColumn('Alt_Phone'))
                                            <th>Alternative Phone <i class="fa fa-fw fa-sort" wire:click="sortBy('alt_phone')"></i></th>
                                            @endif

                                            @if($this->showColumn('Address'))
                                            <th>Address <i class="fa fa-fw fa-sort" wire:click="sortBy('address')"></i></th>
                                            @endif

                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contacts as $contact)

                                        <tr class="@if ($this->isChecked($contact->id))
                    table-primary
                @endif">


                                            <td><input type="checkbox" value="{{ $contact->id }}" wire:model="checked"></td>

                                            @if($this->showColumn('Id'))
                                            <td class="border py-2">{{ $contact->id }}</td>
                                            @endif
                                            @if($this->showColumn('Name'))
                                            <td class="border px-2 py-2">{{ $contact->name }}</td>
                                            @endif
                                            @if($this->showColumn('Email'))
                                            <td class="border px-2 py-2">{{ $contact->email}}</td>
                                            @endif
                                            @if($this->showColumn('Phone'))
                                            <td class="border px-2 py-2">{{ $contact->phone}}</td>
                                            @endif
                                            @if($this->showColumn('Alt_Phone'))
                                            <td class="border px-2 py-2">{{ $contact->alt_phone}}</td>
                                            @endif
                                            @if($this->showColumn('Address'))
                                            <td class="border px-2 py-2">{{ $contact->address}}</td>
                                            @endif


                                            <td class="border px-2 py-2">
                                                @can('contact-list')
                                                <a href="{{ route('contact.show', $contact->id) }}" class="btn btn-info">Show</a>
                                                @endcan
                                                @can('contact-edit')
                                                <a href="{{ route('contact.edit', $contact->id) }}" class="btn btn-primary">Edit</a>
                                                @endcan

                                                @can('contact-delete')
                                                <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                                        Delete
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $contacts->links() }}

                            </div>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
