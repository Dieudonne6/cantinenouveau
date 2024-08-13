@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-body">


        <div class="tab-content col-md-12" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-cantine" role="tabpanel" aria-labelledby="nav-cantine-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab1" role="tablist">
                      <button class="nav-link active" id="nav-etatpaiement-tab" data-bs-toggle="tab" data-bs-target="#nav-etatpaiement" type="button" role="tab" aria-controls="nav-etatpaiement" aria-selected="true">Etat Paiement</button>
                      <button class="nav-link" id="nav-etatdroitconstate-tab" data-bs-toggle="tab" data-bs-target="#nav-etatdroitconstate" type="button" role="tab" aria-controls="nav-etatdroitconstate" aria-selected="false">Etat Droit constate</button>
                    </div>
                  </nav><br><br>
                  <div class="tab-content" id="nav-tabContent1">
                    <div class="tab-pane fade show active" id="nav-etatpaiement" role="tabpanel" aria-labelledby="nav-etatpaiement-tab">
                        {{-- <div class="container"> --}}

                            <form action="{{ url('/traitementetatpaiement') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="debut">Du</label>
                                        <input name="debut" id="debut" type="date" class="typeaheads" required>
                                    </div>
                                    <div class="col">
                                        <label for="fin">Au</label>
                                        <input name="fin" id="fin" type="date" class="typeaheads" required>
                                    </div>
                    
                                    <div class="col">
                                        <!-- Bouton de soumission de formulaire -->
                                        <label for="debut" style="visibility: hidden">supprimer paiement</label>
                                        <button type="submit" class="btn btn-primary w-100">Rechercher</button>
                                    </div>
                                    {{-- <div class="col">
                                            <label for="debut" style="visibility: hidden">supprimer paiememtn</label>
                                            <button type="button" class="btn btn-danger w-200" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                Supp paiement
                                            </button>
                                        </div> --}}
                                    <div class="col">
                                        <label for="debut" style="visibility: hidden">Du</label>
                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Imprimer Etat
                                        </button>
                                    </div>
                                    {{-- <div class="col">
                                        <label for="debut" style="visibility: hidden">Du</label>
                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Imprimer fiche
                                        </button>
                                    </div> --}}
                                </div>
                            </form>
                    
                            @if (Session::has('status'))
                                <div id="statusAlert" class="alert alert-succes btn-primary">
                                    <p>{{ Session::get('status') }}</p>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                Classe
                                            </th>
                                            <th>
                                                Eleve
                                            </th>
                                            <th>
                                                Montant
                                            </th>
                                            <th>
                                                Mois payé(s)
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Reference
                                            </th>
                                            
                                            {{-- <th>
                                                Caissier
                                            </th> --}}
                                            <th>
                                                Action a effectuee
                                            </th>
                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($resultatsIndividuels as $resultatsIndividuel)
                                        <tr>
                    
                                            <td>
                                                {{$resultatsIndividuel->date_paiementcontrat}}
                                            </td>
                    
                                            <td>
                                                {{$resultatsIndividuel->reference_paiementcontrat}}
                                            </td>
                    
                                            <td>
                                                {{$resultatsIndividuel->montant_paiementcontrat}}
                                            </td>
                    
                                            <td style="width: 20px;">
                                                {{$resultatsIndividuel->mois_paiementcontrat}}
                                            </td>
                    
                                            <td>
                                                {{$resultatsIndividuel->date_paiementcontrat}}
                                            </td>
                    
                                            <td>
                                                {{$resultatsIndividuel->date_paiementcontrat}}
                                            </td>
                    
                                            <td>
                                                {{$resultatsIndividuel->date_paiementcontrat}}
                                            </td>
                    
                                            <td>
                    
                                                <form action="{{ url('supprimercontrat/')}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href='/admin/deletecashier/' class='btn btn-danger w-50'>Suspendre</a>
                                                    <input type="submit" class="btn btn-danger w-100" value="Supprimer" >
                                                </form>                         
                                            </td>
                                        </tr>
                    
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    </div>

                    <div class="tab-pane fade" id="nav-etatdroitconstate" role="tabpanel" aria-labelledby="nav-etatdroitconstate-tab">

                        <div class="col-lg-12 grid-margin ">
                            {{-- <div class="card">
                              <div class="card-body"> --}}
                                {{-- <h4 class="card-title">Etats des droits constatés</h4> --}}
                                <form action="{{url('/filteretat')}}" method="POST">
                                  {{csrf_field()}}
                                  <div class="row">
                                    <div class="col-3">
                                      <select class="form-control w-100" name="annee">
                                        <option value="">Sélectionnez une année</option>
                                        @foreach ($annee as $annees)
                                          <option value="{{$annees}}">{{$annees}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    
                                    <div class="col-3">
                                      <select class="form-control w-100" name="classe">
                                        <option value="">Sélectionnez une classe</option>
                                          @foreach ($classe as $classes)
                                            <option value="{{$classes->CODECLAS}}">{{$classes->CODECLAS}}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                    <div class="col-3">
                                      <button type="submit" class="btn btn-primary w-100">
                                      Afficher
                                      </button>
                                    </div>
                                    <div class="col-3">
                                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                          Imprimer la relance
                                      </button>
                                    </div>
                                  </div>
                                </form>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <form action="{{url('/relance')}}" method="POST">
                                      {{ csrf_field() }}
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h1 class="modal-title fs-5" id="exampleModalLabel">Date Buttoir</h1>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                  aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                  <input type="date" class="form-control" name="daterelance">
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                  <button type="submit" class="btn btn-primary">Imprimer</button>
                                              </div>
                                          </div>
                                      </div>
                                  </form>
                              </div>
                                <div class="table-responsive pt-3">
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>
                                          N
                                        </th>
                                        <th>Elève</th>
                                        <th>Classe</th>
                                        <th>Inscription</th>
                                        <th>Janvier</th>
                                        <th>Fevrier</th>
                                        <th>Mars</th>
                                        <th>Avril</th>
                                        <th>Mai</th>
                                        <th>Juin</th>
                                        <th>Septembre</th>
                                        <th>Octobre</th>
                                        <th>Novembre</th>
                                        <th>Décembre</th>
                                        <th>Total</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                          
                                    </tbody>
                                  </table>
                                {{-- </div>
                              </div> --}}
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

@endsection
