var debug=true;
//signing in [
    function initalise() {
        $.post('/scripts/home.php',{type:'session_started'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            $('#body-welcome').fadeOut(500);
            if(result==0) {
                //not logged in
                $('#body-login').delay(800).fadeIn(500);
            }else{
                //logged in, ask them if they want to continue!
                if(data.anonymous==0) $('#body-session-questions-anonymous').show();
                $('#body-session').fadeIn(500);
                getNewQuestion();
            }
        });
    }

    $(document).on('click','#body-login-form-anonymous',function() {
        let checked=$('#body-login-form-anonymous').is(':checked');
        if(checked) $('#body-login-form-name,#body-login-form-age,#body-login-form-gender').attr('disabled','disabled');
        else $('#body-login-form-name,#body-login-form-age,#body-login-form-gender').removeAttr('disabled');
    });

    $(document).on('click','#body-login-form-continue',function() {
        let name=$('#body-login-form-name').val();
        let age=$('#body-login-form-age').val();
        let gender=$('#body-login-form-gender').val();
        let anonymous=$('#body-login-form-anonymous').is(':checked');
        if(!anonymous && name=='' && age=='' && gender=='') {
            Swal.fire('Validation error!','You must have a name, age and gender filled in or click the anonymous checkbox.','error');
            return;
        }

        let post={
            name:name,
            age:age,
            gender:gender,
            anonymous:anonymous
        };

        $.post('/scripts/home.php',{type:'start_session',post:post},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            //registered
            hideEverything();
            if(data.anonymous==0) $('#body-session-questions-anonymous').show();
            $('#body-login').fadeOut(500);
            $('#body-session').delay(800).fadeIn(500);
            getNewQuestion();
        });
    });
//end signing in ]

// withdraw/exit [
    function withdrawFromSurvey() {
        hideEverything();
        $.post('/scripts/home.php',{type:'session_withdraw'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            $('#body-login').show();
        });
    }
    function anonymiseSurvey() {
        $.post('/scripts/home.php',{type:'session_anonymous'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
        });
    }
    function endSurvey() {
        $.post('/scripts/home.php',{type:'session_endsurvey'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            $('#body-login').show();
        });
    }
    $(document).on('click','#body-session-questions-withdraw',function() {
        Swal.fire({
            title:'Withdrawing from survey!',
            html:'Withdrawing from this survey is your choice, but note that withdrawing will remove all your previous answers (if answered any)!<br/>If you want to close this survey instead, please click the exit button instead!<br/>If you want to anonymised the survey, click the anonymous button!',
            // html:true,
            showCancelButton:true,
            confirmButtonText:'Withdraw',
        }).then((result) => {
            if(result.isConfirmed) {
                withdrawFromSurvey();
            }
        });
    });
    $(document).on('click','#body-session-questions-end',function() {
        Swal.fire({
            title:'Ending the survey!',
            html:'Are you sure you want to end the survey?',
            // html:true,
            showCancelButton:true,
            confirmButtonText:'Withdraw',
        }).then((result) => {
            if(result.isConfirmed) {
                endSurvey();
            }
        });
    });
    $(document).on('click','#body-session-questions-anonymous',function() {
        Swal.fire({
            title:'Anonymising survey!',
            html:'Making this survey anonymous will remove all statistical ability from the end report. Instead, it can offer some statistical data with age and gender excluded from the data.<br/>This report would prefer you to be anonymous rather than enter random details.',
            // html:true,
            showCancelButton:true,
            confirmButtonText:'Anonymise',
        }).then((result) => {
            if(result.isConfirmed) {
                anonymiseSurvey();
            }
        });
    });
//end withdraw/exit

// questions [
    function getNewQuestion() {
        hideEverything();
        $.post('/scripts/home.php',{type:'generate_new_question'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            $('#body-session-questions-question-number').text(data.data.question_number);


            let response=data.data.response;
            let graph={
                data:new Array(),
                ykeys:['item1'],
                labels:['item1'],
                xkey:'m',
                xlabel:'day',
                linecolours:['#ggrdd']
            };
            if(response.graph_type==4) {
                $.each(response.response,function(k,i) {
                    graph.data.push({m:i,item1:1});
                });
            }

			$('#body-session-questions-graph').show();
			let Lin = Morris.Area({
				element: 'body-session-questions-graph',
				data:graph.data,
				// [
				// 	{m:'2021-02',item1:2,item2:5,item3:6},
				// 	{m:'2021-03',item1:3,item2:6,item3:9},
				// 	{m:'2021-04',item1:2,item2:4,item3:9},
				// 	{m:'2021-05',item1:1,item2:5,item3:7},
				// 	{m:'2021-06',item1:3,item2:6,item3:10}
				// ],
				xLabels:graph.xlabel,
				xkey:graph.xkey,
                labels:graph.labels,
                ykeys:graph.ykeys,
				// ykeys: ['item1','item2','item3'],
				// labels: ['item1','item2','item3'],
				xLabelFormat: function (d) {
					var weekdays = new Array(7);
					weekdays[0] = "SUN";
					weekdays[1] = "MON";
					weekdays[2] = "TUE";
					weekdays[3] = "WED";
					weekdays[4] = "THU";
					weekdays[5] = "FRI";
					weekdays[6] = "SAT";

					return weekdays[d.getDay()] + ' ' + 
						("0" + (d.getMonth() + 1)).slice(-2) + '-' + 
						("0" + (d.getDate())).slice(-2);
				},
				pointSize: 5,
				hideHover: 'false',
				lineColors: graph.linecolours,
				lineWidth: 5,
				xLabelAngle: 1,
				fillOpacity: 0.1,
				resize: true,
				pointFillColors: ['#fff'],
				pointStrokeColors: ['black'],
				// gridIntegers: true,
				//dateFormat: function (d) {
				//    var ds = new Date(d);
				//    return ds.getDate() + ' ' + months[ds.getMonth()];
				//},
				behaveLikeLine: true,
				parseTime: true //
			});

            $('#body-session-questions').fadeIn(500);
        });
    }
    // $(document).on()

//end questions ]

function hideEverything() {
    $('#body-session-questions,#body-session,#body-login,#body-welcome,#body-session').hide();
}

$(document).ready(function(){
    $('#body-login-form-anonymous').prop('checked',false);
    $('#body-login-form-name,#body-login-form-age,#body-login-form-gender').removeAttr('disabled');
    $('#body-login-form-name,#body-login-form-age,#body-login-form-gender').val('');
    initalise();
});