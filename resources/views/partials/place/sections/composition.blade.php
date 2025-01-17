<section id="composition" class="content-block">
  <div class="columns">
      <div class="column is-8 is-offset-2">
        <div class="columns">
    <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase is-hidden-tablet">La composition</h4>
    <p class="is-hidden-tablet">Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu.</p>

    <div class="column is-4 is-offset-2 is-flex is-flex-direction-column is-justify-content-begin is-align-items-flex-end has-text-right">
      <div class="is-flex is-flex-direction-column is-align-items-center">
        <svg id="waffle" width="100%" height="420" aria-label="Graphique répartition par structure" role="img"></svg>
        @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->type','id_section'=>'composition','type'=>'number','titre'=>"Modifier les types de structures",'description'=>"Quelle est la nature juridique des structures présentes au sein du lieu ? (par ex. entreprise, association, artistes etc.)"])
      </div>
    </div>

    <div class="column is-4 is-flex is-flex-direction-column is-justify-content-center">
      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase is-hidden-mobile mb-0">La composition</h4>
      <p class="is-hidden-mobile">Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu.</p>

      <div class="columns my-2">
        @if (isset($edit) || $place->get('blocs->presentation->donnees->nombre_occupants') > 0)
          <div class="column is-6">
            <span class="is-size-1 has-text-primary has-text-weight-bold font-renner-black">
              {{ $place->get('blocs->presentation->donnees->nombre_occupants') }}
            </span>
            <br/>
            <p style="line-height: 1">
              {{ $place->get('blocs->presentation->donnees->nombre_occupants') > 1 ? 'structures occupantes' : 'structure occupante' }}
              @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->nombre_occupants','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures occupantes",'description' =>"Le nombre de structures exerçant leur activité ou  ayant leurs  locaux au sein du lieu"])
            </p>
          </div>
        @endif

        @if (isset($edit) || $place->get('blocs->composition->donnees->structures_crees') > 0)
          <div class="column is-6">
            <span class="is-size-1 has-text-primary has-text-weight-bold font-renner-black">
              {{ $place->get('blocs->composition->donnees->structures_crees') }}
            </span>
            <br/>
            <p style="line-height: 1">{{ $place->get('blocs->composition->donnees->structures_crees') > 1 ? 'structures créées' : 'structure créée' }}</p>
            @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->structures_crees','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures créées",'description' =>"Le nombre de structures créées au sein du lieu"])
          </div>
        @endif
      </div>

      @if(!$place->isEmptyAccessibilityBySection('publics') && !isset($edit) || isset($edit))
        @include('partials.place.sections.public')
      @endif

      @if(!$place->isEmptyAccessibilityBySection('accessibilite')&& !isset($edit) || isset($edit))
        @include('partials.place.sections.accessibilite')
      @endif
    </div>
    </div>
  </div>
</section>
