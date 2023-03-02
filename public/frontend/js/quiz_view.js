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

//quiz submission check end
    $(document).ready(function(){
        $('#checkAuth').click(function (e) {
            e.preventDefault();
            $("#useLogin").modal('show');
        });
        $('#resultCheckAuth').click(function (e) {
            e.preventDefault();
            $("#useLogin").modal('show');
        });
    });
    
//quiz submission check end
//timer start
let startingMinutes = 0;
let time = parseInt((startingMinutes + get_time)) * 60;

let myInterval = setInterval(updateCountDown, 1000);
function updateCountDown(){
    var countdownEle = document.getElementById('countdown');
    const minutes = Math.floor( time /60 );
    let seconds = time % 60;
    //seconds = seconds < 10 ? '0' + seconds : seconds;
    countdownEle.innerHTML = `${minutes} : ${seconds}`;
    time++;
    $('#time_value').val(minutes);
    
}
//timer end
//progress bar start


    // function countProgress(event){
    //     event.target.classList.remove('ans_done')
    //     event.target.classList.add('ans_done')
    //     let click_count = document.querySelectorAll('.ans_done').length;
    //     console.log(click_count);
    //     let percentages =    percentage(click_count, total_segment);
    //     document.getElementById("progress_wrapper").innerHTML =  `<div class="progress-bar bg-warning" role="progressbar" style="width: ${percentages}%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>`;
    //     document.getElementById("progress_count").innerHTML =  `<p>${percentages}% Completed</p><p>${click_count} of ${segment_id}</p>`;
    // }

    // function percentage(partialValue, totalValue) {
    //     return Math.round((100 * partialValue) / totalValue);
    // }
//progress bar end

