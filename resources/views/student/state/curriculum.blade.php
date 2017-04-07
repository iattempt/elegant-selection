@extends('student/state')
@section('state')

<div id="test"></div>
<div class="container">
  <div class="row d-flex">
    <div id="curriculum_th" class="col-12">
    </div>
    <div id="curriculum_tb" class="col-12">
    </div>
  </div>
</div>

<script>
(function(){
  change(this);
})();
change.state;
change.wd;
change.day;
function change(who) {
  //init
  var test = document.getElementById('test');
  if (typeof change.__initialized == "undefined") {
    change.state = "pre";
    change.wd= "week";
    change.day = "w" + new Date().getDay();

    change.__initialized = true;
    if((screen.width < 768) || (window.matchMedia && window.matchMedia('only screen and (max-width: 640px)').matches)) {
      change.wd = "day";
    }
  }

  //change properties
  if (who.id == "change_state")
    change.state = change.state == "pre" ? "normal" : "pre" ;
  else if (who.id == "change_wd")
    change.wd = change.wd == "week" ? "day" : "week";
  else if (who.id == "w1" ||
            who.id == "w2" ||
            who.id == "w3" ||
            who.id == "w4" ||
            who.id == "w5" ||
            who.id == "w6")
    change.day = who.id;

  //refresh view
  var th = document.getElementById('curriculum_th');
  th.innerHTML="";

  th.insertAdjacentHTML('beforeend', '\
  <div class="row bg-faded text-center text-muted">\
    <div class="mx-auto">\
      切換為:&nbsp;&nbsp;\
      <a id="change_state" onclick="change(this)" href="javascript:void(0)" class="">'+ (change.state == "pre" ? "學期課表" : "預選中課表") +'</a>&nbsp;&nbsp;\
      <a id="change_wd" onclick="change(this)" href="javascript:void(0)" class="">'+ (change.wd == "week" ? "日課表" : "週課表") + '</a>\
    </div>\
  </div>\
  <div class="row d-flex text-center bg-inverse">\
    <div class="col-1">\
  </div>');

  td = th.lastChild;
  for (var i=1; i<=6; i++) {
    if (change.wd == 'week') {
      td.insertAdjacentHTML('beforeend', ''+
        '<a id="w'+i+'" onclick="change(this)" class="col bg-inverse text-white" '+(change.wd == "day" ? "href=javascript:void(0)":"")+'>w'+i+'\
        </a>');
    }
    else if (change.wd == 'day') {
      if (change.day == 'w'+i) {
        td.insertAdjacentHTML('beforeend', ''+
        '<a id="w'+i+'" onclick="change(this)" class="col-3 bg-inverse text-white">w'+i+'\
          </a>');
      }
      else {
        td.insertAdjacentHTML('beforeend', ''+
          '<a id="w'+i+'" onclick="change(this)" class="col bg-primary text-white" '+(change.wd == "day" ? "href=javascript:void(0)":"")+'>w'+i+'\
          </a>');
      }
    }
  }

  th.insertAdjacentHTML('afterend', '</div></div>');

  var lists = {!! json_encode($general->lists) !!};
  var periods = {!! json_encode($general->periods)!!};
  var days = {!! json_encode($general->days) !!};

  //clear
  var tb = document.getElementById('curriculum_tb');
  tb.innerHTML="";


  for (var i in periods) {
    // per line
    if (i%2 == 0)
      tb.insertAdjacentHTML('beforeend', '<div class="row text-center">');
    else
      tb.insertAdjacentHTML('beforeend', '<div class="row text-center bg-faded">');
      

    // append period per line
    var tr = tb.lastChild;
    tr.insertAdjacentHTML('beforeend', '<div class="p-2 col-1 text-center">');
      var td = tr.lastChild;
      td.insertAdjacentHTML('beforeend', periods[i].name);
    tr.insertAdjacentHTML('beforeend', '</div>');

    if (change.wd == 'week') {
      for (var j in days) {
        tr.insertAdjacentHTML('beforeend', '<div class="p-2 col text-center">');
        for (var k in lists) {
          td = tr.lastChild;
          if (lists[k].day_name == days[j].name && lists[k].period_name == periods[i].name){
            if (change.state == 'pre' && lists[k].state == '預選中')
              td.insertAdjacentHTML('beforeend', lists[k].name);
            else if (change.state == 'normal' && lists[k].state == '修課中')
              td.insertAdjacentHTML('beforeend', lists[k].name);
          }
        }
        tr.insertAdjacentHTML('beforeend', '</div>');
      }
    }
    else if (change.wd == 'day') {
      tr.insertAdjacentHTML('beforeend', '<div class="p-2 col text-center">');
      for (var k in lists) {
        td = tr.lastChild;
        if (lists[k].day_name == change.day && lists[k].period_name == periods[i].name){
          if (change.state == 'pre' && lists[k].state == '預選中')
            td.insertAdjacentHTML('beforeend', lists[k].name);
          else if (change.state == 'normal' && lists[k].state == '修課中')
            td.insertAdjacentHTML('beforeend', lists[k].name);
        }
      }
        tr.insertAdjacentHTML('beforeend', '</div>');
    }
    tb.insertAdjacentHTML('beforeend', '</div>');
  }
};
</script>

@endsection
