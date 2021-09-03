@extends('layout')

@section('content')
    <div class="container">
        <div class="hero is-large is-light">
            <section class="section">
                <h1 class="title is-1 has-text-centered">L’ensemble des lieux recensés</h1>
            </section>
        </div>
        <div class="section">
            @foreach ($places as $place)
                <div class="box box-lieu content">
                    <div class="columns is-bordered places-block">
                        <div class="column" style="position:relative; height:250px;">
                          <p>
                            @if ($place->isPublish())
                              <span class="title mb-4"><a href="{{ route('place.show', ['slug' => $place->getSlug()]) }}">{{ $place->get('name') }}</a></span>
                            @else
                              <span class="title mb-4 has-text-primary" style="cursor: not-allowed" title="Lieu non publié pour le moment">{{ $place->get('name') }}</span>
                            @endif
                            <br/>
                            <span class="title_places-city is-size-4" style="font-weight: normal">{{ $place->get('address->city') }} ({{ substr($place->get('address->postalcode'), 0, 2) }})</span>
                          </p>

                          @if ($place->isPublish())
                            <p style="text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3;-webkit-box-orient: vertical;">{{ $place->get('blocs->presentation->donnees->idee_fondatrice') }}</p>
                          @else
                            <p class="is-italic">Ce lieu voudrait vous en dire plus sur lui, mais son propriétaire ne l'a pas encore publié.</p>
                          @endif

                            <ul class="tags_container">
                            @foreach($place->getData()->tags as $tag)
                              <li class="tags">{{$tag}}</li>
                            @endforeach
                            </ul>

                          @if ($place->isPublish())
                            <a href="{{ route('place.show',['slug' => $place->getSlug() ]) }}" class="btn-voir-lieu button is-default">Voir son data panorama</a>
                          @endif
                        </div>
                        <div class="column is-one-third has-text-centered">
                            <div id="carousel-{{ $place->getSlug() }}" class="carousel carousel-container">
                            @if( count($place->getPhotos()) > 0)
                              @foreach($place->getPhotos() as $photo)
                              <img class="img-places" height="230px" src='{{ url("/") }}/images/lieux/{{ $photo }}'>
                              @endforeach
                            @endif
                              <div class="map-place" id="map_{{ $place->getSlug() }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
@section('script_js')
  @parent
  @include('partials.places.map-js')
  @include('partials.places.sortPlaces-js')
@endsection
