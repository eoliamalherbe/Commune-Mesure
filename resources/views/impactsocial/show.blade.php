@extends('impactsocial.layout')

@section('meta_share')
@include('partials.place.meta.opengraph')
@include('partials.place.meta.twitter')
@endsection

@section('script_js')
@parent
<script src="{{ url('/js/readmore.js') }}?{{ file_get_contents(base_path().'/.git/refs/heads/prod') }}"></script>
@endsection

@section('content')

<div id="impact-page">
  <div class="columns is-gapless is-mobile" id="container">

    <div class="column is-full">
      <section id="sommaire">
        <div class="container">
          <div class="valeur individuel">
            <div class="text text--right">
              <h3>Effets<br> individuels</h3>
            </div>
            <div>
              <img class="rounded" src="{{ url('/images/EFFETS-perso.png') }}">
            </div>
          </div>

          <div class="valeur collectif">
            <div class="text text--right">
              <h3>Effets<br> collectifs</h3>
            </div>
            <img class="rounded" src="{{ url('/images/EFFETS-collectifs.png') }}">
          </div>

          <div class="valeur territorial reverse">
            <div class="text">
              <h3>Effets<br> territoriaux</h3>
            </div>
            <img class="rounded" src="{{ url('/images/EFFETS-territoriaux.png') }}">
          </div>

          <div class="valeur urbain reverse">
            <div class="text">
              <h3>Effets sur<br> le projet urbain</h3>
            </div>
            <img class="rounded" src="{{ url('/images/EFFETS-urbain.png') }}">
          </div>

          <img src="{{ url('/images/illustration-sommaire.png') }}" alt="sommaire">
        </div>
      </section>

      <section>
        <div class="custom-background">
          <h2 class="margin-image">effets individuels</h2>
          <div>
            @if (!empty($place->get('blocs->impact_social->donnees->lien_social')))
            <div class="image-start">
              <img src="{{ url('/images/individuel-lien-social.png') }}" alt="lien individuel">
              <div>
                <h3>Lien social</h3>
                <p>Entre quels publics avez-vous pu observer des interactions sociales sur le site ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->lien_social')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->sante_bien_être')))
            <div class="image-start">
              <img src="{{ url('/images/sante.png') }}" alt="santé">
              <div>
                <h3>Santé</h3>
                <p>Avez-vous pu observer un changement des conditions physiques, sociales ou psychiques chez les bénéficiaires du projet, qui puissent être directement lié au projet ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->sante_bien_être')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->insertion_professionnelle')))
            <div class="image-start">
              <img src="{{ url('/images/individuel-insertion-pro.png') }}" alt="insertion professionnelle">
              <div>
                <h3>Insertion professionnelle</h3>
                <p>Avez-vous mis en place des actions de formation, d’accompagnement à la création d’activité ou à l’emploi ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->insertion_professionnelle')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->capacite_agir')))
            <div class="image-start">
              <img src="{{ url('/images/individuel-capacite-agir.png') }}" alt="capacité à agir">
              <div>
                <h3>Capacité à agir</h3>
                <p>De nouveaux projets ou actions (atelier, événement, marché...) imprévus et portés par les bénéficiaires ou occupants ont-il émergé dans le cadre du projet ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->capacite_agir')])
              </div>
            </div>
            @endif
          </div>
        </div>
      </section>

      <section class="gray-background topography-background">
        <div>
          <h2 class="orange center">effets collectifs</h2>
          <div class="row">
            @if (!empty($place->get('blocs->impact_social->donnees->solidarite')))
            <div class="image-start">
              <img src="{{ url('/images/collectif-solidarite.png') }}" alt="collectif solidarite">
              <div>
                <h3>Solidarité</h3>
                <p>Y-a-t-il des échanges, dons ou mutualisations entre personnes au sein du projet ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->solidarite')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->reseaux')))
            <div class="image-start">
              <img src="{{ url('/images/collectif-reseau.png') }}" alt="effets collectifs">
              <div>
                <h3>Réseau de personnes</h3>
                <p>Avez-vous pu observer la création de réseaux de personnes ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->reseaux')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->appartenance_exclusion')))
            <div class="image-start">
              <img src="{{ url('/images/inclusion-exclusion.png') }}" alt="inclusion exclusion">
              <div>
                <h3>Sentiment d'inclusion ou d'exclusion</h3>
                <p>Diriez-vous que certaines personnes se sentent faire partie d'un groupe, ou s'en sentent exclus ? Quelles sont les personnes qui pourraient se sentir exclues ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->appartenance_exclusion')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->egalite_homme_femme')))
            <div class="image-start">
              <img src="{{ url('/images/collectif-egalite.png') }}" alt="collectif solidarite">
              <div>
                <h3>égalité femmes/hommes</h3>
                <p>Diriez-vous qu'il y a plus, moins ou autant de femmes que d'hommes dans le lieu ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->egalite_homme_femme')])
              </div>
            </div>
            @endif
          </div>
        </div>
      </section>

      <section class="topography-background">
        <div>
          <div class="half-image">
            <div>
              <img src="{{ url('/images/quartier-territoire-cadre-vie.png') }}" alt="cadre de vie">
            </div>
            <div>
              <h2 class="quartier">effets sur le quartier et le territoire</h2>
              @if (!empty($place->get('blocs->impact_social->donnees->entretien_des_espaces')))
                <h3>Cadre de vie et attractivité du quartier</h3>
                <p>Avez-vous l’impression que le projet a fait évoluer l’image du quartier ou du territoire ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->cadre_de_vie')])
                <br>
              @endif
              @if (!empty($place->get('blocs->impact_social->donnees->entretien_des_espaces')))
                <h3>Entretien des espaces</h3>
                <p>Le projet a-t-il modifié la gestion urbaine du quartier par les services des collectivités ou de leurs partenaires (ramassage des ordures, propreté, entretien, sécurité...) ?</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->entretien_des_espaces')])
              @endif
            </div>
          </div>
          @if (!empty($place->get('blocs->impact_social->donnees->services_publics')))
          <div class="image-start">
            <img src="{{ url('/images/quartier-service-proximite.png') }}" alt="service de proxmité">
            <div>
              <h3>Services publiques et de proximités</h3>
              <p>Le projet a-t-il permis de répondre à des besoins sociaux urgents du territoire ?</p>
              @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->services_publics')])
            </div>
          </div>
          @endif
          @if (!empty($place->get('blocs->impact_social->donnees->innovation_publique')))
          <div class="image-start">
            <img src="{{ url('/images/quartier-innovations.png') }}" alt="innovation publique">
            <div>
              <h3>Innovation publique</h3>
              <p>Avez-vous pu constater que vos modalités de collaboration avec les partenaires publics et privés ont fait évoluer leurs pratiques professionnelles ?</p>
              @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->innovation_publique')])
            </div>
          </div>
          @endif
        </div>
      </section>

      <!-- <section class="blue-background">
        <div>
          <div class="half-image">
            <div>
              <h2 class="urbain">Impact sur le projet urbain</h2>
              <h3>Gouvernance partagée transitoire/pérenne</h3>
              <p>
                Le projet a été monté en lien avec le projet urbain, un comité de pilotage transversal au projet urbain et au lieu se réunit régulièrement.
              </p>
              <br>
              <h3>évolution du diagnostic de la programmation et du dessin</h3>
              <p>Le projet a un impact sur le diagnostic du projet urbain, il a permis de mieux connaitre les pratiques: modes d'habiter, travailler, jouer… sur le site. Il a fait évoluer le type d'espaces publics (ex: création d'espaces de jeu, de sports, espaces intimes, frontage, jardins partagés...), leurs ambiances</p>
              <br>
              <h3>Missions ou métiers émergeants</h3>
              <p>
                Le projet change mes méthodes de travail (ex: connexion plus forte avec le terrain, les besoins et usages du site)
              </p>
              @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->capacite_agir')])
            </div>
            <div>
              <img src="{{ url('/images/projet-urbain.png') }}" alt="projet urban">
            </div>
          </div>
        </div>
      </section> -->

    </div>
  </div>
</div>
@endsection