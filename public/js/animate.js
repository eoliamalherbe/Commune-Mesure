function animateValue(obj) {
    var end = parseInt(obj.dataset.total);
    var start = 0;
    var range = end - start;
    var duration = 1000;

    var interval = duration / end

    if (range > 0) {
        var current = start;
        var increment = end > start ? 1 : -1;
        var plus = 0;

        if(end > 100){
          plus = end%100;
          end = end - plus;
          increment = end / 100;
        }else{
          interval = 500 / end;
        }

        var timer = setInterval(function() {
            current += increment;
            obj.innerHTML = current;
            if (parseInt(current) == parseInt(end)) {
              obj.innerHTML = current + plus;
                clearInterval(timer);
            }
        }, Math.abs(interval));
    }
}

window.onload = (event) => {
    var values = document.querySelectorAll(".animate-value")
    values.forEach(function (v) {
        animateValue(v)
    })
}
