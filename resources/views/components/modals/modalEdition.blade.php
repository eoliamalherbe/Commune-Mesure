@if(!isset($edit))
  @php return @endphp
@endif
<span class="icon-edit">
    <i class="fa fa-pen modal-crayon" data-modal="{{$chemin}}" title="Éditer la section"></i>
</span>
<div class="modal" id="{{$chemin}}" style="z-index: 100000;">
  <div class="modal-background" ></div>
  <div class="modal-card">

    <header class="modal-card-head">
      <div class="modal-card-title">
        <h2 >
           @if(isset($titre))
              {{$titre}}
           @endif
         </h2>
      </div>
       <button class="delete modal-croix" aria-label="close"></button>
       <br>

    </header>

    <form method="POST" action="{{route('place.update',['slug' => $slug, 'auth' => $auth , 'chemin'=>$chemin])}}">

      <section class="modal-card-body">
        @if(isset($description))
          <small style='margin-left:10px'>
             {{$description}}
          </small>
          <hr style='border:1px solid #dbdbdb'>
        @endif

        @php ($valueChemin = $place->get($chemin)) @endphp

        @if(is_array($valueChemin))
          @if (isset($type) && $type =='text')
            @foreach( $valueChemin as $value)
            <input name="champ{{array_search($value,$valueChemin)}}"  value="{{ $value }}"/>
            <br>
            @endforeach
            <input name="champ{{count($valueChemin)}}"></input>
            <br>
            <input name="champ{{count($valueChemin)+1}}"></input>
            <input hidden name="type" value="{{$type}}"></input>
          @endif
        @elseif(is_object($valueChemin) && isset($type) && $type == "checkbox")
          @php $i=0; @endphp
          @foreach($valueChemin as $value => $check)
            <label>{{$value}} : </label>
            @if($check)
              <input type="checkbox" name="{{$i}}" checked>
              <br>
            @else
              <input type="checkbox" name="{{$i}}">
              <br>
            @endif
            @php $i++; @endphp
            <input hidden name="type" value="{{$type}}"></input>
          @endforeach
        @elseif(is_object($valueChemin) && isset($type) && $type == "number")
          @php $i=0; @endphp
          @foreach($valueChemin as $k => $v)
            <label>{{$k}} : </label>
            <input class='input-number' type="number" name="{{$i}}" value="{{$v}}">
            <br>
            @php $i++; @endphp
            <input hidden name="type" value="{{$type}}"></input>
          @endforeach
        @elseif( isset($type) && $type== 'text' )
          <textarea name='champ' class="textarea">{{ $valueChemin }}</textarea>
        @elseif( isset($type) && $type== 'number')
          <input class='input-number' name='champ' type='number' value = "{{ $valueChemin }}"/>
        @elseif ( isset($type) && $type == 'decimal')
          <input class='input-number'step="any" name='champ' type='number' value = "{{ $valueChemin }}"/>
        @elseif ( isset($type) && $type == 'date')
          <input class='input-number' step="any" name='champ' type='date' value = "{{ $valueChemin }}"/>
        @endif

        <span style="opacity: 0.2;">$place->{{ $chemin }}</span>
      </section>
      <footer class="modal-card-foot">
        <input type="button" class="button modal-croix" value="Annuler"/>
        <span class="container">
          <span class="field is-grouped is-grouped-right">
            <button class="button is-success" type="submit">Enregistrer</button>
          </span>
        </span>
      </footer>
    </form>
  </div>
</div>
