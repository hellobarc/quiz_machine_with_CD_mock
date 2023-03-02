let multiple_count = 1;
function myFunction() {
      $('#add-option').append(`<label for="name" class="mb-2 fw-bold">Question Option</label><div class="d-flex justify-content-start">
           <div class="form-group">
                <input type="text" name="blank_answer[]" class="form-control" placeholder="option">
           </div>
           <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" name="is_correct[]" value="${multiple_count}" id="flexCheckDefault${multiple_count}">
              <label class="form-check-label" for="flexCheckDefault${multiple_count}">is correct</label>
           </div>
        </div>`);
      multiple_count++;      
}

//multiple choice option selection start
function hitMultipleChoice(key,option_key) {
   let input_var = "user_multiple_choice_"+option_key;
   var element = document.getElementById(input_var).value = key;
   let myid = "#multipleColorChange_"+option_key+key;
   let myclass = ".option_item"+option_key;
   $(myclass).removeClass("mltiple_choice_option_correct");
   $(myid).addClass("mltiple_choice_option_correct");
}
//multiple choice option selection end
function addClass(col, row_item) {
   let checkId = "#right_check_"+col+"_"+ row_item;
   let input_val = [col,row_item];
   $("#checked_input_"+row_item).val(input_val);

   $(".empty_box_"+row_item).removeClass("active_check");
   $(checkId).addClass("active_check");
}

function allowDrop(ev) {
   ev.preventDefault();
 }
 
 function drag(ev) {
   ev.dataTransfer.setData("text", ev.target.id);
   
 }
 
 function drop(ev, id, ques_id) {
   ev.preventDefault();

   
   var data = ev.dataTransfer.getData("text");

   let text = document.getElementById(data).innerHTML;
  
   ev.target.appendChild(document.getElementById(data).cloneNode(true));
   let destination = "valDrop_"+id+ques_id;
   var val=document.getElementById(destination);
   //let pattern = /\d+/;
   //let seril_number = text.match(pattern);
   let input_text =  text.substr(2);
   val.value=input_text;
   

 }

 
let time = parseInt((startingMinutes - get_time)) * 60;

let myInterval = setInterval(updateCountDown, 1000);
function updateCountDown(){
    var countdownEle = document.getElementById('countdown');
    const minutes = Math.floor( time /60 );
    let seconds = time % 60;
    //seconds = seconds < 10 ? '0' + seconds : seconds;
    countdownEle.innerHTML = `${minutes} : ${seconds}`;
    time--;
    $('#time_value').val(minutes);
    
}

 function effect(key){
   let indicator_id = "indicator_"+key;
   $("#"+indicator_id).addClass("active_indicator");
 }
 

 