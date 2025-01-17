<script type="text/javascript">
const graph_superficie_id = 'graph_superficie'
const tooltip_superficie_id = 'tooltip-superficie';
const span_superficie_totale = document.getElementById('graph_superficie__superficie_totale')

const width = parseInt(d3.select('svg#graph_superficie').style('width'), 10)
const height = parseInt(d3.select('svg#graph_superficie').style('width'), 10)
const margin = {top: 1, right: 1, bottom: 2, left: 1}

const superficie_totale = {{ $place->get('blocs->presentation->donnees->surfaces->totale') ?: 0 }};
const superficie_exterieure = {{ $place->get('blocs->presentation->donnees->surfaces->exterieur') ?: 0 }};
const superficie_bureaux = {{ $place->get('blocs->presentation->donnees->surfaces->bureau') ?: 0 }};
const superficie_ateliers = {{ $place->get('blocs->presentation->donnees->surfaces->atelier') ?: 0 }};

if (superficie_exterieure + superficie_bureaux + superficie_ateliers > superficie_totale) {
  const msg = 'Le cumul des superficies ne peut pas dépasser le total'
  d3.select('#'+graph_superficie_id)
    .append('text')
    .attr("x", "50%")
    .attr("y", "50%")
    .attr("dominant-baseline", "middle")
    .attr("text-anchor", "middle")
    .attr('style', 'font-family: "Font Awesome 6 free"; font-size: 3rem;')
    .text('\uf071')
  d3.select('#'+graph_superficie_id)
    .append('text')
    .attr("x", "50%")
    .attr("y", "60%")
    .attr("dominant-baseline", "middle")
    .attr("text-anchor", "middle")
    .text(msg)

  @if (! isset($edit))
    document.querySelector('#'+graph_superficie_id).style.display = 'none'
  @endif

  throw new Error(msg)
}

var superficie_interieure = superficie_totale - superficie_exterieure;
var superficie_autres = superficie_interieure - superficie_bureaux - superficie_ateliers;
var superficie_pc_interieur = superficie_interieure / superficie_totale;
var superficie_pc_bureaux = superficie_bureaux / superficie_interieure;
var superficie_pc_ateliers = superficie_ateliers / superficie_interieure;
var superficie_pc_autres = superficie_autres / superficie_interieure;
var superficie_names = [
    'superficie_exterieur',
    'superficie_autres',
    'superficie_bureaux',
    'superficie_ateliers'
]

var superficie_human_keys = [
  'superficie_exterieur',
  'superficie_bureaux',
  'superficie_ateliers',
  'superficie_autres',
];

var function_superficie_width = function(d) {
    if (d == 'superficie_exterieur') return width - margin.left - margin.right;
    if (d == 'superficie_interieure') return Math.sqrt(superficie_pc_interieur) * function_superficie_width('superficie_exterieur');
    if (d == 'superficie_autres') return function_superficie_width('superficie_interieure') * superficie_pc_autres;
    if (d == 'superficie_bureaux') return function_superficie_width('superficie_interieure') - function_superficie_width('superficie_autres');
    if (d == 'superficie_ateliers') return function_superficie_width('superficie_bureaux');
}

var function_superficie_height = function(d) {
    if (d == 'superficie_exterieur') return height - margin.top - margin.bottom;
    if (d == 'superficie_interieure') return Math.sqrt(superficie_pc_interieur) * function_superficie_height('superficie_exterieur');
    if (d == 'superficie_autres') return function_superficie_height('superficie_interieure');
    if (d == 'superficie_bureaux') return function_superficie_width('superficie_interieure') * function_superficie_height('superficie_interieure') * superficie_pc_bureaux / function_superficie_width('superficie_bureaux');
    if (d == 'superficie_ateliers') return function_superficie_height('superficie_autres') - function_superficie_height('superficie_bureaux');
}

const superficie_colors = ['#90bd95','#e9c3b7', '#f5e6dd', '#ea7a6c', '#f9f7f4'];

var function_superficie_fill = function(d) {
    if (d == 'superficie_exterieur') return d3.rgb(superficie_colors[0]);
    if (d == 'superficie_ateliers') return d3.rgb(superficie_colors[1]);
    if (d == 'superficie_bureaux') return d3.rgb(superficie_colors[2]);
    if (d == 'superficie_autres') return d3.rgb(superficie_colors[3]);
    return d3.rgb(superficie_colors[4]);
}

var function_superficie_x = function(d) {
    if (d == 'superficie_exterieur') return 0;
    if (d == 'superficie_interieure') return (function_superficie_width('superficie_exterieur') - Math.sqrt(superficie_pc_interieur) * function_superficie_width('superficie_exterieur') ) ;
    if (d == 'superficie_bureaux') return function_superficie_x('superficie_interieure');
    if (d == 'superficie_autres') return function_superficie_x('superficie_bureaux') + function_superficie_width('superficie_bureaux');
    if (d == 'superficie_ateliers') return function_superficie_x('superficie_bureaux');

}

var function_superficie_y = function(d) {
    if (d == 'superficie_exterieur') return 0 + margin.top;
    if (d == 'superficie_interieure') return (function_superficie_height('superficie_exterieur') - Math.sqrt(superficie_pc_interieur) * function_superficie_height('superficie_exterieur')) + margin.top;
    if (d == 'superficie_autres') return function_superficie_y('superficie_interieure');
    if (d == 'superficie_bureaux') return function_superficie_y('superficie_interieure');
    if (d == 'superficie_ateliers') return function_superficie_y('superficie_interieure') + function_superficie_height('superficie_bureaux');
}

var function_superficie_text_1 = function(d) {
    if (! function_superficie_width(d) || !function_superficie_height(d) || !function_get_superficie(d)) {
        return ;
    }
    if( function_get_superficie(d) < 31){
      return;
    }
    if (d == 'superficie_exterieur') return 'Extérieurs : '+function_get_superficie(d) + ' m²';;
    if (function_superficie_height(d) < 100) {
        if (d == 'superficie_autres') return 'Autres : '+ function_get_superficie(d) + ' m²';
        if (d == 'superficie_bureaux') return 'Bureaux : '+ function_get_superficie(d) + ' m²';
        if (d == 'superficie_ateliers') return 'Ateliers : '+ function_get_superficie(d) + ' m²';
    }else {
        if (d == 'superficie_autres') return 'Autres :';
        if (d == 'superficie_bureaux') return 'Bureaux :';
        if (d == 'superficie_ateliers') return 'Ateliers :';
    }
    return ;
}

var function_get_superficie = function(d) {
  if (d == 'superficie_autres') return parseInt(superficie_autres);
  if (d == 'superficie_bureaux') return parseInt(superficie_bureaux);
  if (d == 'superficie_ateliers') return parseInt(superficie_ateliers);
  if (d == 'superficie_exterieur') return parseInt(superficie_exterieure);
}

var function_superficie_text_2 = function(d) {
    if (! function_superficie_width(d) || !function_superficie_height(d) || !function_get_superficie(d)) {
        return ;
    }
    if( function_get_superficie(d) < 31){
      return;
    }
    if (function_superficie_height(d) >= 100) {
        if (d == 'superficie_autres') return function_get_superficie(d) + ' m²';
        if (d == 'superficie_bureaux') return function_get_superficie(d) + ' m²';
        if (d == 'superficie_ateliers') return function_get_superficie(d) + ' m²';
    }
}

var function_superficie_text_x = function(d) {
    const rect = d3.select('#rect_'+d)
    return margin.left + +rect.style('x').replace('px', '') + +rect.style('width').replace('px', '') / 2;
}

var function_superficie_text_y = function(d) {
    if (d == 'superficie_exterieur') {
        return ((function_superficie_height('superficie_exterieur') - function_superficie_height('superficie_interieure') ) / 2 ) + margin.top ;
    }
    return function_superficie_y(d) + function_superficie_height(d) / 2 ;
}

var superficie_rect_onmouseover = function(d, i) {
    d3.select('#'+tooltip_superficie_id)
      .style('opacity', function(a) {
          if (!function_get_superficie(d)) {
            return 0;
          }
          if (d == 'superficie_exterieur')  { return 1; }
          if (d == 'superficie_interieure') { return 1; }
          if (d == 'superficie_autres')     { return 1; }
          if (d == 'superficie_bureaux')    { return 1; }
          if (d == 'superficie_ateliers')   { return 1; }
          return 0;
      } )
     .text( function(a) {
        if (d == 'superficie_exterieur') return 'Extérieurs : '+function_get_superficie(d) + ' m²';;
        if (d == 'superficie_autres') return 'Autres : '+ function_get_superficie(d) + ' m²';
        if (d == 'superficie_bureaux') return 'Bureaux : '+ function_get_superficie(d) + ' m²';
        if (d == 'superficie_ateliers') return 'Ateliers : '+ function_get_superficie(d) + ' m²';
      })
    d3.select('#text_'+d)
        .attr('class', 'highlight');
}

var superficie_rect_onmouseout = function(d, i) {
    d3.select('#text_'+d)
        .attr('class', 'normal');
    d3.select('#'+tooltip_superficie_id)
      .style('opacity', 0);
}

var superficie_figures = d3.select("#graph_superficie")
    .attr('width', width)
    .attr('height', height)
    .append('g')
      .attr('class', 'figures')
      .attr('transform', "translate(" + margin.left + "," + margin.top + ")")

d3.select('body')
    .append('div')
    .attr('id', tooltip_superficie_id)
    .attr('class', 'd3_tooltip')
    .attr('style', 'position: absolute; opacity: 0;');

var superficie_rects = superficie_figures.selectAll('rect')
    .data(superficie_names)
    .enter()
    .append('rect')
    .attr('id', (d) => 'rect_'+d)
    .attr('class', (d) => d)
    .attr('fill', function_superficie_fill )
    .attr('width', function_superficie_width )
    .attr('height', function_superficie_height )
    .attr('x', function_superficie_x )
    .attr('y', function_superficie_y )
    .attr('stroke', 'black')
    .attr('stroke-width', 2)
    .on("mouseover", superficie_rect_onmouseover)
    .on("mouseout", superficie_rect_onmouseout)
    .on('mousemove', function(d) {
      d3.select('#'+tooltip_superficie_id)
        .style('left', (d3.event.pageX + 25) + 'px')
        .style('top', (d3.event.pageY + 25) + 'px')
    })
var superficie_gtexts = d3.select("#graph_superficie")
    .append('g')
    .attr('class', 'texts')
    .attr('style','font-family:"Renner Bold";font-size:1rem')

var superficie_texts = superficie_gtexts.selectAll('text')
    .data(superficie_names)
    .enter()
    .append('text')
    .attr('id', (d) => 'text_'+d)
    .attr('x', function_superficie_text_x )
    .attr('y', function_superficie_text_y )
    .attr('text-anchor', 'middle')

superficie_texts.append('tspan')
    .text( function_superficie_text_1 )

superficie_texts.append('tspan')
    .text( function_superficie_text_2 )
    .attr('x', function_superficie_text_x )
    .attr('y', function_superficie_text_y )
    .attr('dy', '17' )

// On update la superficie totale du titre
let superficie_totale_titre = 0
superficie_names.forEach(function (s) {
  superficie_totale_titre += function_get_superficie(s)
})
span_superficie_totale.textContent = superficie_totale_titre

</script>
