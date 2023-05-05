<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material/img/sidebar-1.jpg') }}">

    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <a href="#" class="simple-text logo-normal">
            Silke
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {{ Request::is('/') ? 'active' :'' }}">

                <a class="nav-link" href="/">

                    <i style="color:black;" class="material-icons">dashboard</i>
                    <p style="color:black;">Dashboard</p>
                </a>
            </li>
            @can('user-list')
            <li class="nav-item {{ Request::is('users') ? 'active' :'' }}">

                <a class="nav-link" href="/users">


                    <i style="color:black;" class="material-icons">people</i>


                    <p style="color:black;">Users</p>
                </a>
            </li>
            @endcan
            @can('role-list')
            <li class="nav-item {{ Request::is('roles') ? 'active' :'' }}">

                <a class="nav-link" href="/roles">


                    <i style="color:black;" class="material-icons">work</i>


                    <p style="color:black;">Roles</p>
                </a>
            </li>
            @endcan
            @can('contact-list')
            <li class="nav-item {{ Request::is('contacts') ? 'active' :'' }}">

                <a class="nav-link" href="/contacts">


                    <i style="color:black;" class="material-icons">phone</i>


                    <p style="color:black;">Contact</p>
                </a>
            </li>
            @endcan
            <li class="nav-item">

                <a class="nav-link" href="/download">


                    <i style="color:black;" class="material-icons">download</i>


                    <p style="color:black;">Import Sample</p>
                </a>
            </li>



        </ul>
    </div>
</div>
@section('script')
<script>
    $(document).ready(function() {

        $('ul.nav > li')
            .click(function(e) {
                $('ul.nav > li')
                    .removeClass('active');
                $(this).addClass('active');
            });
    });

</script>
@endsection
