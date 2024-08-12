<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex justify-content-center">
    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
      <a class="navbar-brand brand-logo" href="{{url('/vitrine')}}">Cantine</a>
      <a class="navbar-brand brand-logo-mini" href="../../index.html"><img src="../../images/logo-mini.svg" alt="logo"/></a>
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="typcn typcn-th-menu"></span>
      </button>
    </div>
  </div>
 
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="typcn typcn-th-menu"></span>
    </button>
    <div class="">
   
      @if (Session::has('nom_user') || Session::has('prenom_user'))
      <h5 class="mb-0">
          Bienvenue {{ Session::get('nom_user') }} {{ Session::get('prenom_user') }}
      </h5>
      @endif
    </div>
    <div>   
      <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="nav-logout">Déconnexion</button>            
      </form>
    </div>
 
  </div>
</nav>