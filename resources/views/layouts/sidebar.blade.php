<nav class="sidebar sidebar-offcanvas " id="sidebar" style="max-width: 240px">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#Cantine" aria-expanded="false" aria-controls="Cantine">
        <i class="typcn typcn-document-text menu-icon"></i>
        <span class="menu-title">Cantine</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="Cantine">
        <ul class="nav flex-column sub-menu">
          {{-- <li class="nav-item"> <a class="nav-link" href="{{url('/inscriptioncantine')}}">Inscriptions</a></li> --}}

          {{-- <li class="nav-item"> <a class="nav-link" href="{{url('/classes')}}">Toutes les classes</a></li> --}}

          {{-- <li class="nav-item"> <a class="nav-link" href="{{url('/listecontrat')}}">Liste des Contrats</a></li> --}}
          
          {{-- <li class="nav-item menu-item-has-children">
            <a href="" class="nav-link">Etats</a>
            <ul class="sub-menus">
              <li>
                <a href="{{url('/etatpaiement')}}">Etat des paiements</a>
              </li>
              <li>
                <a href="{{url('/etatdroits')}}">Etat des droits constatés</a>
              </li>
            
            </ul>
          </li> --}}
          {{-- <li class="nav-item"> <a class="nav-link" href="{{url('/etat')}}">Les Etats</a></li>

          <li class="nav-item"> <a class="nav-link" href="{{url('/duplicatafacture')}}">Duplicata facture</a></li> --}}

          {{-- <div class="dropdown">
            <li class="nav-item">
            <button class="btn btn-light-lg dropdown-toggle" type="button" id="dropdownMenuSizeButton90" data-toggle="dropdown" 
            aria-haspopup="true" aria-expanded="false" _msttexthash="313989" _msthash="279"> Etats </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton90" style="" _mstvisible="0" >
              <a class="dropdown-item" href="#" _msttexthash="20" _msthash="20" _mstvisible="1">Etat des paiements</a>
              <a class="dropdown-item" href="#" _msttexthash="21" _msthash="21" _mstvisible="1">Etat des droits constatés</a>
              <a class="dropdown-item" href="#" _msttexthash="21" _msthash="21" _mstvisible="1">Lettre de relance</a>
            </div> --}}
         
          {{-- <li class="nav-item"> <a class="nav-link {{ request()->is('inscriptioncantine') ? 'active' : '' }}" href="{{url('/inscriptioncantine')}}">Inscriptions</a></li> --}}
          {{-- <li class="nav-item"> <a class="nav-link" href="{{url('/listecontrat')}}">Liste des Contrats</a></li> --}}
          <li class="nav-item"> <a class="nav-link {{ request()->is('listecontrat') ? 'active' : '' }}"  href="{{url('/listecontrat')}}">Liste des Contrats</a></li>
          <li class="nav-item"> <a class="nav-link {{ request()->is('etat' || 'filteretat') ? 'active' : '' }}"  href="{{url('/etat')}}">Etats</a></li>
          <li class="nav-item"> <a class="nav-link {{ request()->is('duplicatafacture') ? 'active' : '' }}" href="{{url('/duplicatafacture')}}">Duplicata facture</a></li>
          {{-- <li class="nav-item"> <a class="nav-link {{ request()->is('filteretat') ? 'active' : '' }}" href="{{url('/filteretat')}}"></a></li> --}}
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/parametre')}}">
        <i class="typcn typcn-globe-outline menu-icon"></i>
        <span class="menu-title" _msttexthash="234962" _msthash="98">Paramètres</span>
      </a>
    </li>
  </ul>
</nav>
