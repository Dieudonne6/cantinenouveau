<nav class="sidebar sidebar-offcanvas " id="sidebar" style="max-width: 240px">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link collapsed" data-toggle="collapse" href="#Cantine" aria-expanded="false" aria-controls="Cantine">
        <i class="typcn typcn-document-text menu-icon"></i>
        <span class="menu-title">Cantine</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="collapse" id="Cantine">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
           
            <a class="nav-link {{ request()->is('listecontrat') || request()->is('paiementcontrat') ? 'active' : '' }}" href="{{url('/listecontrat')}}">Liste des Contrats</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('etat') || request()->is('filteretat') ? 'active' : '' }}" href="{{url('/etat')}}">Etats</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('duplicatafacture') ? 'active' : '' }}" href="{{url('/duplicatafacture')}}">Duplicata facture</a>
          </li>
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
