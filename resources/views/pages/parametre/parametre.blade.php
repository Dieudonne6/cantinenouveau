
@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="card">
    <div class="card-body">

      <button class="btn btn-arrow" onclick="window.history.back();">
           <i class="fas fa-arrow-left"></i> Retour
       </button>
       <br></br>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-cantine-tab" data-bs-toggle="tab" data-bs-target="#nav-cantine" type="button" role="tab" aria-controls="nav-cantine" aria-selected="true">Cantine</button>
              {{-- <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Tables des paramères</button>
              <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Modifier les bornes de l'exercice</button>
              <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-ouverture" aria-selected="false">Op. Ouverture</button>
              <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-confimp" aria-selected="false">Configurer imprimente</button>
              <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-ouverture" aria-selected="false">Changement de trimestre</button> --}}
            </div>
        </nav>
        
        <div class="tab-content col-md-10 mx-auto " id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-cantine" role="tabpanel" aria-labelledby="nav-cantine-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab1" role="tablist">
{{--                       <button class="nav-link" id="nav-identification-tab" data-bs-toggle="tab" data-bs-target="#nav-identification" type="button" role="tab" aria-controls="nav-identification" aria-selected="false">Identification</button>
 --}}                      <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-frais&année" type="button" role="tab" aria-controls="nav-frais&année" aria-selected="true">Frais & Année</button>
                      <button class="nav-link" id="nav-connexionBD-tab" data-bs-toggle="tab" data-bs-target="#nav-connexionBD" type="button" role="tab" aria-controls="nav-connexionBD" aria-selected="false">ConnexionBD</button>
                      <button class="nav-link" id="nav-facture-tab" data-bs-toggle="tab" data-bs-target="#nav-facture" type="button" role="tab" aria-controls="nav-facture" aria-selected="false">Facture</button>
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent1">

                    @if(Session::has('status'))
                    <div id="statusAlert" class="alert alert-succes btn-primary">
                        {{ Session::get('status')}}
                    </div>
                    @endif
                    
                    {{-- <div class="tab-pane fade" id="nav-identification" role="tabpanel" aria-labelledby="nav-identification-tab">
                        <div class="row">
                            <div class="col-md-10 mx-auto grid-margin stretch-card">
                              <div class="card">
                                <div class="card-body">
                                  @if(Session::has('status'))
                                  <div id="statusAlert" class="alert alert-succes btn-primary">
                                  {{ Session::get('status')}}
                                  </div>
                                  @endif
                                  {{-- erreur concernant un nouveau utilisateur --}}
                                  {{-- @if($errors->any())
                                  <div id="statusAlert" class="alert alert-danger">
                                      <ul>
                                          @foreach($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                  </div>
                                  @endif
                                  <h4 class="card-title">Enregistrement d'un utilisateur</h4>
                                  <form action="{{ url('/enregistreruser') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                      <label for="exampleInputUsername1">Nom groupe</label>
                                      <input type="text" class="form-control" name="nomgroupe" id="exampleInputUsername1" placeholder="Nom groupe">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInputUsername1">Nom d'utilisateur</label>
                                      <input type="text" class="form-control" name="login" id="exampleInputUsername1" placeholder="Nom d'utilisateur">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Nom</label>
                                      <input type="text" class="form-control" name="nom" id="exampleInputEmail1" placeholder="Nom">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInputPassword1">Prenom</label>
                                      <input type="text" class="form-control" name="prenom" id="exampleInputPassword1" placeholder="Prenom">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInputConfirmPassword1">Mot de passe</label>
                                      <input type="password" class="form-control" name="password" id="exampleInputConfirmPassword1" placeholder="Mot de passe">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInputConfirmPassword1">Utilisateur actif</label>
                                      <select name="user_actif" class="form-select">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInputConfirmPassword1">Administrateur</label>
                                      <select name="administrateur" class="form-select">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                      </select>
                                    </div>
                                   <div class="form-group">
                                      <label for="exampleInputConfirmPassword1">Photos</label>
                                      <input type="file" class="form-control" name="image" id="exampleInputConfirmPassword1" placeholder="Photo">
                                    </div>
                                    <div class="mb-5">
                                      <button type="submit" class="btn btn-primary mr-2">Enregistrer</button>
                                      <button class="btn btn-light">Annuler</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                    </div> --}}

                    <div class="tab-pane fade show active" id="nav-frais&année" role="tabpanel" aria-labelledby="nav-frais&année-tab">
                        <div class="content-wrapper">
                            @if($param)
                              <form action="{{url('modifierfrais/'.$param->id_paramcontrat)}}" method="POST">
                                {{csrf_field()}}
                                @method('PUT')
                                <input type="hidden" value="{{$param->id_paramcontrat}}" name="id_paramcontrat">
                                <div class="row">
                                  <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                          <h4 class="card-title" _msttexthash="323960" _msthash="106">Année académique </h4>
                                          <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Aide</button>
                                        </div>
                                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                          <div class="offcanvas-header">
                                            <h5 class="offcanvas-title" id="offcanvasRightLabel">Frais et année</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                          </div>
                                          <div class="offcanvas-body">
                                            <p>Définir l’année académique et les frais d’inscriptions mensuels pour chaque enseignement. </p>
                                          </div>
                                        </div> 
                                        <div class="form-group row">
                                          <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                          <div class="col-sm-12">
                                            <input type="text" name="anneencours_paramcontrat" class="form-control" id="exampleInputUserannée"  value="{{$param->anneencours_paramcontrat}}" _mstplaceholder="117572" _msthash="115" required>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                        
                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title" _msttexthash="323960" _msthash="106">Frais d'inscriptions Primaire</h4> 
                                             
                                        <div class="form-group row">
                                          <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                          <div class="col-sm-9">
                                            <input type="text" name="fraisinscription_paramcontrat" value="{{$param->fraisinscription_paramcontrat}}" class="form-control" id="exampleInputUserannée" placeholder="2024" _mstplaceholder="117572" _msthash="115" required>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title" _msttexthash="323960" _msthash="106">Frais d'inscriptions Maternel</h4>      
                                        <div class="form-group row">
                                          <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                          <div class="col-sm-9">
                                            <input type="text" name="fraisinscription_mat" value="{{$param->fraisinscription_mat}}" class="form-control" id="exampleInputUserannée" placeholder="2024" _mstplaceholder="117572" _msthash="115" required>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title" _msttexthash="323960" _msthash="106">Frais mensuel Maternel</h4>      
                                        <div class="form-group row">
                                          <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                          <div class="col-sm-9">
                                            <input type="text" name="fraisinscription2_paramcontrat" value="{{$param->fraisinscription2_paramcontrat}}"  class="form-control" id="exampleInputUserannée"  _mstplaceholder="117572" _msthash="115" required>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title" _msttexthash="323960" _msthash="106">Frais mensuel Primaire</h4>      
                                          <div class="form-group row">
                                            <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                            <div class="col-sm-9">
                                              <input type="text" name="coutmensuel_paramcontrat" class="form-control" value="{{$param->coutmensuel_paramcontrat}}"  id="exampleInputUserannée" _mstplaceholder="117572" _msthash="115" required>
                                            </div>
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="mb-5">
                                    <button type="submit" class="btn btn-primary" _msttexthash="98280" _msthash="118">Modifier</button>
                                  </div>
                                </div>
                              </form>
                            @else
                              <form action="{{url('nouveaufrais')}}" method="POST">
                                {{csrf_field()}}
                                <div class="row">
                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title" _msttexthash="323960" _msthash="106">Année académique</h4>
                                        <div class="form-group row">
                                          <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                          <div class="col-sm-9">
                                            <input type="text" name="anneencours_paramcontrat" class="form-control" id="exampleInputUserannée" placeholder="2024" _mstplaceholder="117572" _msthash="115">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                        
                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title" _msttexthash="323960" _msthash="106">Frais d'inscriptions</h4>      
                                        <div class="form-group row">
                                          <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                          <div class="col-sm-9">
                                            <input type="text" name="fraisinscription_paramcontrat" class="form-control" id="exampleInputUserannée" placeholder="2024" _mstplaceholder="117572" _msthash="115">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                        
                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title" _msttexthash="323960" _msthash="106">Frais mensuel Maternel</h4>      
                                        <div class="form-group row">
                                          <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                          <div class="col-sm-9">
                                            <input type="text" name="fraisinscription2_paramcontrat" class="form-control" id="exampleInputUserannée" placeholder="2024" _mstplaceholder="117572" _msthash="115">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title" _msttexthash="323960" _msthash="106">Frais mensuel Primaire</h4>      
                                          <div class="form-group row">
                                            <label for="exampleInputUsername" class="col-sm-3 col-form-label" _msttexthash="202930" _msthash="116"></label>
                                            <div class="col-sm-9">
                                              <input type="text" name="coutmensuel_paramcontrat" class="form-control" id="exampleInputUserannée" placeholder="2024" _mstplaceholder="117572" _msthash="115">
                                            </div>
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                  <button type="submit" class="btn btn-primary w-100" _msttexthash="98280" _msthash="118">Enregistrer</button>
                                </div>
                              </form>
                            @endif
                          </div>
                    </div>

                    <div class="tab-pane fade" id="nav-connexionBD" role="tabpanel" aria-labelledby="nav-connexionBD-tab">
                        <div class="col-md grid-margin stretch-card">
                            <div class="card">
                              <div class="card-body">  
                                {{-- erreur concernant la connexion a la base de donne --}}
                                {{-- @if($errors->any())
                                <div id="statusAlert" class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif --}}
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                  <h4>Connexion à la base de données</h4>
                                  <!-- Bouton pour ouvrir l'offcanvas -->
                                  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightHelp" aria-controls="offcanvasRightHelp">Aide</button>
                                </div>
                                
                                <!-- Offcanvas -->
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightHelp" aria-labelledby="offcanvasRightHelpLabel">
                                  <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasRightHelpLabel">ConnexionBD </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                  </div>
                                  <div class="offcanvas-body">
                                    <p>Entrer les informations pour se connecter à la base de données.</p>
                                  </div>
                                </div>
                                
                                <form action="{{url('connexion')}}" method="POST">
                                  {{csrf_field()}}
                                  <div class="form-group row">
                                    <label for="exampleInputServeur" class="col-sm-3 col-form-label">Serveur</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="exampleInputServeur" name="nameserveur" placeholder="localhost" required>
                                    </div>
                                  </div>
                                
                                  <div class="form-group row">
                                    <label for="exampleInputDatabase" class="col-sm-3 col-form-label">Base de donnée</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="exampleInputDatabase" name="namebase" placeholder="Nom de la base de donnée" required>
                                    </div>
                                  </div>
                                
                                  <div class="form-group row">
                                    <label for="exampleInputUsername" class="col-sm-3 col-form-label">Utilisateur</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="exampleInputUsername" name="user" placeholder="Utilisateur" required>
                                    </div>
                                  </div>
                                
                                  <div class="form-group row">
                                    <label for="exampleInputPassword" class="col-sm-3 col-form-label">Mot de passe</label>
                                    <div class="col-sm-9">
                                      <input type="password" class="form-control" id="exampleInputPassword" name="password" placeholder="Mot de passe">
                                    </div>
                                  </div>
                                
                                  <div class="mb-5">
                                    <button type="submit" class="btn btn-primary mr-2">Connexion</button>
                                  </div>
                                </form>
                                                                
                              </div>
                            </div>
                          </div>
                    </div>

                    <div class="tab-pane fade" id="nav-facture" role="tabpanel" aria-labelledby="nav-facture-tab">
                      <div class="row">
                        <div class="col-md-6 mx-auto grid-margin stretch-card">
                          <div class="card">
                            <div class="card-body">
                              <!-- Radios et bouton d'aide -->
                              <div class="form-group d-flex align-items-center">
                                <div class="form-check pr-4">
                                  <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2" checked>
                                    EMECEF
                                  </label>
                                </div>
                                <div class="form-check pr-4">
                                  <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="option1">
                                    MCF
                                  </label>
                                </div>
                                <!-- Bouton pour ouvrir l'offcanvas d'aide -->
                                <button class="btn btn-primary aide-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFactureHelp" aria-controls="offcanvasFactureHelp">Aide</button>
                              </div>
                    
                              <!-- Offcanvas -->
                              <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFactureHelp" aria-labelledby="offcanvasFactureHelpLabel">
                                <div class="offcanvas-header">
                                  <h5 class="offcanvas-title" id="offcanvasFactureHelpLabel">Facture </h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="display: inline-block; margin-left: 10px;"></button>
                                </div>
                                <div class="offcanvas-body d-flex justify-content-between">
                                  <div>
                                    <p>Entrer les informations en fonction du choix du type de factures choisi.</p>
                                  </div>
                                </div>
                              </div>
                    
                              {{-- formulaire EMECEF --}}
                              <form action="{{url('paramsemecef')}}" method="POST" enctype="multipart/form-data" id="div1" class="d-block">
                                {{csrf_field()}}
                                <h4 class="card-title">Informations Emecef</h4>
                    
                                <div class="form-group">
                                  <label for="exampleInputUsername1">IFU</label>
                                  <input type="text" class="form-control" name="ifu" id="exampleInputUsername1" placeholder="IFU" required>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Token</label>
                                  <input type="text" class="form-control" name="token" id="exampleInputEmail1" placeholder="Token" required>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername1">Groupe de taxe</label>
                                  <input type="text" class="form-control" name="taxe" id="exampleInputUsername1" placeholder="Groupe de taxe" required>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername1">Type de facture</label>
                                  <input type="text" class="form-control" name="type" id="exampleInputUsername1" placeholder="Type de facture" required>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername1">LOGO</label>
                                  <input type="file" class="form-control" name="logo" id="exampleInputUsername1" placeholder="Logo" required>
                                </div>
                                <div class="mb-5">
                                  <button type="submit" class="btn btn-primary mr-2">Envoyer</button>
                                  <input type="reset" class="btn btn-light" value="Annuler">
                                </div>
                              </form>
                    
                              {{-- formulaire MCF --}}
                              <form class="forms-sample d-none" id="div2">
                                <h4 class="card-title">Informations Mcef</h4>
                                <div class="form-group">
                                  <label for="exampleInputUsername1">IFU</label>
                                  <input type="text" class="form-control" id="exampleInputUsername1" placeholder="IFU">
                                </div>
                                <div class="mb-5">
                                  <button type="submit" class="btn btn-primary mr-2">Enregistrer</button>
                                  <button class="btn btn-light">Annuler</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    

                  </div>
            </div>

            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...2</div>

            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...3</div>

        </div>

    </div>
</div>

<style>
  .btn-arrow {
      position: absolute;
      top: 0px; /* Ajustez la position verticale */
      left: 0px; /* Positionnez à gauche */
      background-color: transparent !important;
      border:1px !important;
      text-transform: uppercase !important;
      font-weight: bold !important;
      cursor: pointer!important;
      font-size: 17px!important; /* Taille de l'icône */
      color: #b51818!important; /* Couleur de l'icône */
  }
  
  .btn-arrow:hover {
      color: #b700ff !important; /* Couleur au survol */
  }
  .aide-btn {
    position: absolute;
    top: 10px; /* Ajuster la valeur en fonction de l'espacement souhaité */
    right: 10px; /* Ajuster la valeur en fonction de l'espacement souhaité */
    z-index: 10; /* Assurez-vous qu'il reste visible */
}

  </style>

@endsection