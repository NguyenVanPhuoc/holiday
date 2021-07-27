
$(document).ready(function($) {
    // Select2 js
        $('select.js-select2').select2({
            minimumResultsForSearch: Infinity
        })
        .on("select2:open", function () {
        $('.select2-results__options').scrollbar().parent().addClass('scrollbar-inner');
        });
    function add7DaysW(){
        var d = new Date();
        var day = d.getDay();
        if(day>=0 && day<=3) {day= '+9d'} //Sunday monday tuesday wednesday
        else if(day!=6) {day= '+10d'}     // thurday and friday
        else {day= '+11d'};               // Saturday 
        return day                         
    }

    $("#frm-appointmentDate .input-group.date").datepicker({
        format: "DD dd-mm-yyyy",
        startDate: new Date(),
        endDate: add7DaysW(),
        showOtherMonths: true,
        daysOfWeekDisabled: [0,6],
        autoclose: true,
    }); 
    $('#frm-arrivalDate .input-group.date , #frm-GuideDate .input-group.date , #frm-AccomDate .input-group.date ').datepicker({
        format: "DD, dd/mm/yyyy",
        startDate: new Date(),
        autoclose: true,
    });
    $('#fromPeriodDate').datepicker({
        format: "DD, dd/mm/yyyy",
        startDate: new Date(),
        autoclose: true,
    }).on('changeDate', function(e) {
        $('#frm-GuideDate .input-group.date').datepicker('setStartDate',e.date);
        $('#frm-AccomDate .input-group.date').datepicker('setStartDate',e.date);
    });
    $('#toPeriodDate').datepicker({
        format: "DD, dd/mm/yyyy",
        startDate: new Date(),
        autoclose: true,
    }).on('changeDate', function(e) {
        $('#frm-GuideDate .input-group.date').datepicker('setEndDate',e.date);
        $('#frm-AccomDate .input-group.date').datepicker('setEndDate',e.date);
    });
    $("#arrivalDate,#duration").on("change",function(){
        var arrivalDate = $("#arrivalDate").val();
        var duration = parseInt($("#duration").val());
        if(arrivalDate != "" && duration > 0){
            var date = new Date($("#frm-arrivalDate .input-group.date").datepicker('getDates'));
            var add = duration - 1;
            date.setDate(date.getDate() + add);
            var text = getFormattedDate(date);
            $('.departure').find('.date-duration').text(text);
        }
    });
    function getFormattedDate(date) {
      var year = date.getFullYear();
     /* var month = (1 + date.getMonth()).toString();
      month = month.length > 1 ? month : '0' + month;*/
      var monthNumber = date.getMonth();
      var months = [ "January", "February", "March", "April", "May", "June", 
               "July", "August", "September", "October", "November", "December" ];
      var monthName = months[monthNumber];        
      var day = date.getDate().toString();
      day = day.length > 1 ? day : '0' + day;
      var W = date.getDay().toString();
      var text = "";
      if(W == 0){
         text = 'Sunday';
      }else if(W == 1){
          text = 'Monday';
      }else if(W == 2){
          text = 'Tuesday';
      }else if(W == 3){
          text = 'Wednesday';
      }else if(W == 4){
          text = 'Thursday';
      }else if(W == 5){
          text = 'Friday';
      }else if(W == 6){
          text = 'Saturday';
      }
      return text +', '+day + ' ' + monthName + ' ' + year;
    }
    // Calculate Approximate departure date
    Date.prototype.addDays = function(days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }
    $('input[name="arrivalDate"], select[name="duration"]').on('change', function() {
        var arr =  $('#frm-arrivalDate .input-group.date').datepicker('getDate');
        var dur = $('select[name="duration"]').val();
        var res = arr.addDays(parseInt(dur));
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var d = new Date(res);
        var dayName = days[d.getDay()];
        var day = ("0" + d.getUTCDate()).slice(-2);
        if(dur == 0) {
            $(this).parents('.arravel-duration').find('p#approDate span').text();
        } else {
            var month =("0" + (d.getUTCMonth()+1)).slice(-2);
            var year = d.getUTCFullYear();
            $(this).parents('.arravel-duration').find('p#approDate span').text(dayName+','+' '+day+'/'+month+'/'+year);
        }        
    });
    // Show hide app-name in mobile-app
    $('ul.socials.m-app label').on('mouseenter',function() {
        $(this).siblings('.app-name').removeClass('hide');
    });
    $('ul.socials.m-app label').on('mouseleave',function() {
        $(this).siblings('.app-name').addClass('hide');
    });
    $('ul.socials.m-app label').on('change',function() {
        if($(this).children('input[type=checkbox]').is(':checked')) {
            $(this).siblings('input').removeClass('hide');
            $(this).siblings('.app-name').addClass('active');
        }else {
            $(this).siblings('input').addClass('hide');
            $(this).siblings('.app-name').removeClass('active');
        } 
    });

    // Least one checkbox id seleced
    $("#frm-destination input[type=checkbox]").on("change",function(){
        var check = false;
        $("#frm-destination .col-md-4").each(function(){
            if($(this).find("input[type=checkbox]").is(":checked")){
                check = true;
            }
        });
        if(check == true){
            $("#frm-destination input").prop("required",false);
        }else{
            $("#frm-destination input").prop("required",true);
        }
    });
    // Turn off 1 on 2 or turn off this
    $('#frm-meals .checkbox input[name=meals]').on('click', function(){
        if($(this).parents('.radio-rq').hasClass('active')){
            $(this).parents('.radio-rq').removeClass('active');
            $(this).prop('checked', false);
        } 
        else{
            $('#frm-meals .radio-rq').removeClass('active');
            $('#frm-meals .checkbox input[name=meals]').prop('checked', false);
            $(this).parents('.radio-rq').addClass('active');
            $(this).prop('checked', true);
        }
    });
    // Turn off 1 on 2 item or turn off it's
    $('#frm-accommodation .checkbox input[name=accommodation]').on('click', function(){
        if($(this).parents('.radio-rq').hasClass('active')){
            $(this).parents('.radio-rq').removeClass('active');
            $(this).prop('checked', false);
        } 
        else{
            $('#frm-accommodation .radio-rq').removeClass('active');
            $('#frm-accommodation .checkbox input[name=accommodation]').prop('checked', false);
            $(this).parents('.radio-rq').addClass('active');
            $(this).prop('checked', true);
        }
    });
    $('#frm-project .checkbox input').on('click', function(){
        if($(this).parents('.radio-rq').hasClass('active')){
            $(this).parents('.radio-rq').removeClass('active');
            $(this).prop('checked', false);
        } 
        else{
            $('#frm-project .radio-rq').removeClass('active');
            $('#frm-project .checkbox input').prop('checked', false);
            $(this).parents('.radio-rq').addClass('active');
            $(this).prop('checked', true);
        }
    });
    // Turn off 1 on 2 item or turn off it's
    $('#frm-canContact input[name=canContact]').on('change',function(){
        var check = false;
        $("#frm-canContact .radio-rq").removeClass("active");
        $('#frm-canContact .radio-rq').each(function(){
            if($(this).find('input[name=canContact]').is(":checked") && $(this).find('input[name=canContact]').val() == "Yes"){
                $(this).addClass("active");
                check = true;
            }else if($(this).find('input[name=canContact]').is(":checked") && $(this).find('input[name=canContact]').val() == "No"){
                $(this).addClass("active");
                check = false;
            }
        });

        if(check == true){
            $('#frm-sponsor').slideToggle();
            //$('.hideNoCall').slideToggle();
            $('#frm-appointmentDate input[name=appointmentDate]').prop('required',true);
            $('#frm-appointmentDate').addClass('has-feedback');
        }else if(check == false){
            $('#frm-sponsor').slideToggle();
            //$('.hideNoCall').slideToggle();
            $('#frm-appointmentDate input[name=appointmentDate]').prop('required',false);
            $('#frm-appointmentDate').removeClass('has-feedback');
        }   
    });
    // Modal scroll
    $('.modal-preview .scrollbar-inner').scrollbar();
    // Show preview create my trip
    $("#btn-trip").on("click",function(e){
        e.preventDefault();
        var title = $("select[name=title]").find(":selected").val();
        var firstName = $("input[name=firstName]").val();
        var lastName = $("input[name=lastName]").val();
        $(".box-modal .fullName span").text(' '+title+firstName+' '+lastName);
        var email = $("#frm-email input[name=email]").val();
        $(".box-modal .email span").text(email);
        var areaCode = $("#frm-phone select[name=areaCode]").find(":selected").val();
        var numberPhone = $("#frm-phone input[name=numberPhone]").val();
        if(numberPhone.charAt(0) == '0'){
            var validateNumberPhone = numberPhone.substr(1); 
        }else{
            var validateNumberPhone = numberPhone;
        }
        $(".box-modal .phone span").text(' '+areaCode+validateNumberPhone);
        var ageGroup = $("#frm-ageGroup select[name='ageGroup']").find(":selected").val();
        $(".box-modal .are-group span").text(ageGroup);
        var country = $("#frm-country select[name=country]").find(":selected").val();
        $(".box-modal .country span").text(country);
        if($("#frm-newsletter input[name=newsletter]").is(':checked')){
            $(".box-modal .newsletter span").text('Yes');
        }
        else{
            $(".box-modal .newsletter span").text('No');
        }
        var numAdult = $("select[id=numAdult]").find(":selected").val();
        var numChild = $("select[id=numChild]").find(":selected").val();
        var numBaby = $("select[id=numBaby]").find(":selected").val();
        var numberTravels = "";
        if(parseInt(numAdult) > 0){
            numberTravels += ' Adult: ' + numAdult;
        }
        if(parseInt(numChild) > 0){
            if(numberTravels == ""){
                numberTravels +=  'Child 2-12 y.o: ' + numChild;
            }else{
                numberTravels +=  ' / Child 2-12 y.o: ' + numChild;
            }
        }
        if(parseInt(numBaby) > 0){
            if(numberTravels == ""){
                numberTravels +=  'Baby < 2 y.o: ' + numBaby;
            }else{
            numberTravels += ' / Baby < 2 y.o: ' + numBaby;
            }
        }
        $(".box-modal .travel-of span").text(numberTravels);
        var condition = $("input[name=condition]:checked").val();
        $(".box-modal .phy-cal span").text(condition);
        var descProject = $("textarea[name=descProject]").val();
        $(".box-modal .project-item1").text(descProject);
        var furtherNote = $("textarea[name=furtherNote]").val();
        $(".box-modal .project-item2").text(furtherNote);
        if($('#frm-meals .checkbox ').hasClass('active')){
            var meals = $("#frm-meals input[name=meals]:checked").val();
            $(".box-modal .meals span").text(meals);
        }else{
            var meals = ""
            $(".box-modal .meals span").text(meals);
        }
        
        var mealsTrips = $("textarea[name=mealsTrips]").val();
        $(".box-modal .project-item3").text(mealsTrips);
        var arrivalDate = $("input[name=arrivalDate]").val();
        $(".box-modal .arrival span").text(arrivalDate);
        var duration = $("select[name=duration]").val();
        $(".box-modal .duration span").text(duration);
        var destination = "";
        $("#frm-destination .custom-checkbox .selected").each(function(){
            var checkbox = $(this).find("input[name='destination[]']");
            if(checkbox.is(":checked")){
                if(destination == ""){
                    destination = checkbox.val();
                }else{
                    destination = destination + ' / ' + checkbox.val();
                }
            }
        });
        $(".box-modal .destination span").text(destination);
        var tourType = "";
        $("#frm-tourType .custom-checkbox .selected").each(function(){
            var checkbox = $(this).find("input[name='tourType[]']");
            if(checkbox.is(":checked")){
                if(tourType == ""){
                    tourType = checkbox.val();
                }else{
                    tourType = tourType + ' / ' + checkbox.val();
                }
            }
        });

        $(".box-modal .tour span").text(tourType);
        if($('#frm-accommodation .checkbox ').hasClass('active')){
            var accommodation = $("#frm-accommodation input[name=accommodation]:checked").val();
            $(".box-modal .accommodation span").text(accommodation);
        }else{
            var accommodation = ""
            $(".box-modal .accommodation span").text(accommodation);
        }
        var doubleRoom = $("select[name=doubleRoom]").val();
        var twinRoom = $("select[name=twinRoom]").val();
        var individualRoom = $("select[name=individualRoom]").val();
        var tripleRoom = $("select[name=tripleRoom]").val();
        var rooms = "";
        if(parseInt(doubleRoom) > 0){
            if(rooms == ""){
                rooms += "Double: "+ doubleRoom;
            }else{
                rooms += " / Double: "+ doubleRoom;
            }
        }
        if(parseInt(twinRoom) > 0){
            if(rooms == ""){
                rooms += "Twin: "+ twinRoom;
            }else{
                rooms += " / Twin: "+ twinRoom;
            }
        }
        if(parseInt(individualRoom) > 0){
            if(rooms == ""){
                rooms += "Individual: "+ individualRoom;
            }else{
                rooms += " / Individual: "+ individualRoom;
            }
        }
        if(parseInt(tripleRoom) > 0){
            if(rooms == ""){
                rooms += "Individual: "+ tripleRoom;
            }else{
                rooms += " / Individual: "+ tripleRoom;
            }
        }
        $(".box-modal .room span").text(rooms);
        var budgetPerson = $("input[name=budgetPerson]").val();
        var currencyPerson = $("select[name=currencyPerson]").find(":selected").val();
        $(".box-modal .person span").text(budgetPerson+' '+ currencyPerson);
        var hobbies = $("textarea[name=hobbies]").val();
        $(".box-modal .better-item1").text(hobbies);
        var lastLong = $("textarea[name=lastLong]").val();
        $(".box-modal .better-item2").text(lastLong);
        if($("input[id=callYes]").is(":checked")){
            $(".box-modal .text-can span").text('Yes');
        }else{
            $(".box-modal .text-can span").text('No');
        }
        if($("#frm-canContact input[name=canContact]:checked").val() == "Yes"){
            var appointmentDate = $("input[name=appointmentDate]").val();
            $(".box-modal .app-date span").text(appointmentDate);
            var timeZone = $("select[name=timeZone]").find(":selected").val();
            $(".box-modal .app-zone span").text(timeZone);
            var accWhatsapp = $('input[name=whatsapp_id]').val();
            var accFacebook = $('input[name=facebook_id]').val();
            var accSkype = $('input[name=skype_id]').val();
            $('.box-modal .apps-call span').text('');
            if($("#frm-mobileApp label input#whatsapp").is(":checked")){
                var name = $("#frm-mobileApp label input#whatsapp").val();
                $(".box-modal .apps-call span").append(name+' : '+accWhatsapp);
            }
            if($("#frm-mobileApp label input#messenger").is(":checked")){
                var name = $("#frm-mobileApp label input#messenger").val();
                if($('.box-modal .apps-call span').length >0){
                    $(".box-modal .apps-call span").append(' / ' +name +' : '+ accFacebook);
                }else{
                    $(".box-modal .apps-call span").append(name +' : '+ accFacebook);
                }
            }
            if($("#frm-mobileApp label input#skype").is(":checked")){
                var name = $("#frm-mobileApp label input#skype").val();
                if($(".box-modal .apps-call span").length > 0){
                    $(".box-modal .apps-call span").append(' / ' +name +' : '+ accSkype);
                }else{
                    $("box-modal .apps-call span").append(name +' : '+ accSkype);
                }
            }   
            var timeSlot = "";
            $("#frm-timeSlot .custom-checkbox .item").each(function(){
                var checkbox = $(this).find("input[name='timeSlot[]']");
                if(checkbox.is(":checked")){
                    if(timeSlot == ""){
                        timeSlot = checkbox.val();
                    }else{
                        timeSlot = timeSlot + ' / ' + checkbox.val();
                    }
                }
            }); 
            $(".box-modal .app-slot span").text(timeSlot);
        }else{
            $(".box-modal .app-date span").text('');
            $(".box-modal .app-zone span").text('');
            $(".box-modal .apps-call span").text('');
            $(".box-modal .app-slot span").text('');
        }
        var titleIntro =  $("select[name=titleIntro]").find(":selected").val();
        var firstNameIntro = $("input[name=firstNameIntro]").val();
        var lastNameIntro = $("input[name=lastNameIntro]").val();
        if(titleIntro != "" || firstNameIntro != "" || lastNameIntro != ""){
            $(".box-modal .text-recon span").text('Yes');
            if(titleIntro != "" && firstNameIntro != "" && lastNameIntro != ""){
                $(".box-modal .sponsor span").text(' '+titleIntro+firstNameIntro+' '+lastNameIntro);
            }else if(titleIntro == "" && firstNameIntro != "" && lastNameIntro != ""){
                $(".box-modal .sponsor span").text(' '+firstNameIntro+' '+lastNameIntro);
            }else if(titleIntro != "" && firstNameIntro != "" && lastNameIntro == ""){
                $(".box-modal .sponsor span").text(' '+titleIntro+' '+firstNameIntro);
            }else if(titleIntro != "" && firstNameIntro == "" && lastNameIntro != ""){
                $(".box-modal .sponsor span").text(' '+titleIntro+' '+lastNameIntro);
            }
        }else{
            $(".box-modal .text-recon span").text('No');
            $(".box-modal .sponsor span").text('');
        }
        $("#createMyTripModal").modal("show");
    });
    // Show preview personalize
    $("#btn-person").on("click",function(e){
        e.preventDefault();
        var title = $("select[name=title]").find(":selected").val();
        var firstName = $("input[name=firstName]").val();
        var lastName = $("input[name=lastName]").val();
        $(".box-modal .fullName span").text(' '+title+firstName+' '+lastName);
        var email = $("#frm-email input[name=email]").val();
        $(".box-modal .email span").text(email);
        var areaCode = $("#frm-phone select[name=areaCode]").find(":selected").val();
        var numberPhone = $("#frm-phone input[name=numberPhone]").val();
        if(numberPhone.charAt(0) == '0'){
            var validateNumberPhone = numberPhone.substr(1); 
        }else{
            var validateNumberPhone = numberPhone;
        }
        $(".box-modal .phone span").text(' '+areaCode+validateNumberPhone);
        var ageGroup = $("#frm-ageGroup select[name='ageGroup']").find(":selected").val();
        $(".box-modal .are-group span").text(ageGroup);
        var country = $("#frm-country select[name=country]").find(":selected").val();
        $(".box-modal .country span").text(country);
        if($("#frm-newsletter input[name=newsletter]").is(':checked')){
            $(".box-modal .newsletter span").text('Yes');
        }
        else{
            $(".box-modal .newsletter span").text('No');
        }
        var numAdult = $("select[id=numAdult]").find(":selected").val();
        var numChild = $("select[id=numChild]").find(":selected").val();
        var numBaby = $("select[id=numBaby]").find(":selected").val();
        var numberTravels = "";
        if(parseInt(numAdult) > 0){
            numberTravels += ' Adult: ' + numAdult;
        }
        if(parseInt(numChild) > 0){
            if(numberTravels == ""){
                numberTravels +=  'Child 2-12 y.o: ' + numChild;
            }else{
                numberTravels +=  ' / Child 2-12 y.o: ' + numChild;
            }
        }
        if(parseInt(numBaby) > 0){
            if(numberTravels == ""){
                numberTravels +=  'Baby < 2 y.o: ' + numBaby;
            }else{
            numberTravels += ' / Baby < 2 y.o: ' + numBaby;
            }
        }
        $(".box-modal .travel-of span").text(numberTravels);
        var condition = $("input[name=condition]:checked").val();
        $(".box-modal .phy-cal span").text(condition);
        var explainTrip = $("textarea[name=explainTrip]").val();
        $(".box-modal .project-item1").text(explainTrip);
        var otherDest = $("textarea[name=otherDest]").val();
        $(".box-modal .project-item2").text(otherDest);
        if($('#frm-meals .checkbox ').hasClass('active')){
            var meals = $("#frm-meals input[name=meals]:checked").val();
            $(".box-modal .meals span").text(meals);
        }else{
            var meals = ""
            $(".box-modal .meals span").text(meals);
        }
        
        var mealsTrips = $("textarea[name=mealsTrips]").val();
        $(".box-modal .project-item3").text(mealsTrips);
        var arrivalDate = $("input[name=arrivalDate]").val();
        $(".box-modal .arrival span").text(arrivalDate);
        var duration = $("select[name=duration]").val();
        $(".box-modal .duration span").text(duration);
        if($('#frm-accommodation .checkbox ').hasClass('active')){
            var accommodation = $("#frm-accommodation input[name=accommodation]:checked").val();
            $(".box-modal .accommodation span").text(accommodation);
        }else{
            var accommodation = ""
            $(".box-modal .accommodation span").text(accommodation);
        }
        var doubleRoom = $("select[name=doubleRoom]").val();
        var twinRoom = $("select[name=twinRoom]").val();
        var individualRoom = $("select[name=individualRoom]").val();
        var tripleRoom = $("select[name=tripleRoom]").val();
        var rooms = "";
        if(parseInt(doubleRoom) > 0){
            if(rooms == ""){
                rooms += "Double: "+ doubleRoom;
            }else{
                rooms += " / Double: "+ doubleRoom;
            }
        }
        if(parseInt(twinRoom) > 0){
            if(rooms == ""){
                rooms += "Twin: "+ twinRoom;
            }else{
                rooms += " / Twin: "+ twinRoom;
            }
        }
        if(parseInt(individualRoom) > 0){
            if(rooms == ""){
                rooms += "Individual: "+ individualRoom;
            }else{
                rooms += " / Individual: "+ individualRoom;
            }
        }
        if(parseInt(tripleRoom) > 0){
            if(rooms == ""){
                rooms += "Individual: "+ tripleRoom;
            }else{
                rooms += " / Individual: "+ tripleRoom;
            }
        }
        $(".box-modal .room span").text(rooms);
        var budgetPerson = $("input[name=budgetPerson]").val();
        var currencyPerson = $("select[name=currencyPerson]").find(":selected").val();
        $(".box-modal .person span").text(budgetPerson+' '+ currencyPerson);
        var hobbies = $("textarea[name=hobbies]").val();
        $(".box-modal .better-item1").text(hobbies);
        var lastLong = $("textarea[name=lastLong]").val();
        $(".box-modal .better-item2").text(lastLong);
        if($("input[id=callYes]").is(":checked")){
            $(".box-modal .text-can span").text('Yes');
        }else{
            $(".box-modal .text-can span").text('No');
        }
        if($("#frm-canContact input[name=canContact]:checked").val() == "Yes"){
            var appointmentDate = $("input[name=appointmentDate]").val();
            $(".box-modal .app-date span").text(appointmentDate);
            var timeZone = $("select[name=timeZone]").find(":selected").val();
            $(".box-modal .app-zone span").text(timeZone);
            var accWhatsapp = $('input[name=whatsapp_id]').val();
            var accFacebook = $('input[name=facebook_id]').val();
            var accSkype = $('input[name=skype_id]').val();
            $('.box-modal .apps-call span').text('');
            if($("#frm-mobileApp label input#whatsapp").is(":checked")){
                var name = $("#frm-mobileApp label input#whatsapp").val();
                $(".box-modal .apps-call span").append(name+' : '+accWhatsapp);
            }
            if($("#frm-mobileApp label input#messenger").is(":checked")){
                var name = $("#frm-mobileApp label input#messenger").val();
                if($('.box-modal .apps-call span').length >0){
                    $(".box-modal .apps-call span").append(' / ' +name +' : '+ accFacebook);
                }else{
                    $(".box-modal .apps-call span").append(name +' : '+ accFacebook);
                }
            }
            if($("#frm-mobileApp label input#skype").is(":checked")){
                var name = $("#frm-mobileApp label input#skype").val();
                if($(".box-modal .apps-call span").length > 0){
                    $(".box-modal .apps-call span").append(' / ' +name +' : '+ accSkype);
                }else{
                    $("box-modal .apps-call span").append(name +' : '+ accSkype);
                }
            }   
            var timeSlot = "";
            $("#frm-timeSlot .custom-checkbox .item").each(function(){
                var checkbox = $(this).find("input[name='timeSlot[]']");
                if(checkbox.is(":checked")){
                    if(timeSlot == ""){
                        timeSlot = checkbox.val();
                    }else{
                        timeSlot = timeSlot + ' / ' + checkbox.val();
                    }
                }
            }); 
            $(".box-modal .app-slot span").text(timeSlot);
        }else{
            $(".box-modal .app-date span").text('');
            $(".box-modal .app-zone span").text('');
            $(".box-modal .apps-call span").text('');
            $(".box-modal .app-slot span").text('');
        }
        var titleIntro =  $("select[name=titleIntro]").find(":selected").val();
        var firstNameIntro = $("input[name=firstNameIntro]").val();
        var lastNameIntro = $("input[name=lastNameIntro]").val();
        if(titleIntro != "" || firstNameIntro != "" || lastNameIntro != ""){
            $(".box-modal .text-recon span").text('Yes');
            if(titleIntro != "" && firstNameIntro != "" && lastNameIntro != ""){
                $(".box-modal .sponsor span").text(' '+titleIntro+firstNameIntro+' '+lastNameIntro);
            }else if(titleIntro == "" && firstNameIntro != "" && lastNameIntro != ""){
                $(".box-modal .sponsor span").text(' '+firstNameIntro+' '+lastNameIntro);
            }else if(titleIntro != "" && firstNameIntro != "" && lastNameIntro == ""){
                $(".box-modal .sponsor span").text(' '+titleIntro+' '+firstNameIntro);
            }else if(titleIntro != "" && firstNameIntro == "" && lastNameIntro != ""){
                $(".box-modal .sponsor span").text(' '+titleIntro+' '+lastNameIntro);
            }
        }else{
            $(".box-modal .text-recon span").text('No');
            $(".box-modal .sponsor span").text('');
        }
        $("#personalizeModal").modal("show");
    });
    // Contact Form Submit
    $(document).on("submit", "#contact-frm" , function(e){
        e.preventDefault(); 
        var title = $("select[name=title]").find(":selected").val();
        var fullName = $("input[name=fullName]").val();
        //var lastName = $("input[name=lastName]").val();
        var email = $("input[name=email]").val();
        //var areaCode = $("select[name=areaCode]").find(":selected").val();
        var numberPhone = $("input[name=numberPhone]").val();
        if(numberPhone.charAt(0) == '0'){
            var validateNumberPhone = numberPhone.substr(1); 
        }else{
            var validateNumberPhone = numberPhone;
        }
        
        //var ageGroup = $("select[name='ageGroup']").find(":selected").text();
        //var country = $("select[name=country]").find(":selected").text();
        var subject = $("select[name=subject]").find(":selected").text();
        if($("input[name=newsletter]").is(':checked')){
            var newsletter = "Yes";
        }
        else{
            var newsletter = "No";
        }
        var message = $("textarea[name=message]").val();
        //var titleIntro =  $("select[name=titleIntro]").find(":selected").val();
        //var firstNameIntro = $("input[name=firstNameIntro]").val();        
        //var lastNameIntro = $("input[name=lastNameIntro]").val();
        var url = $("input[name=url-frm]").val();
        var _token = $("input[name=_token]").val();
        var response = grecaptcha.getResponse();
        if(response.length === 0) {
            e.preventDefault();
            $(this).find('.g-recaptcha').addClass('error');
        } else {
            $(this).find('.g-recaptcha').removeClass('error');
        }
        if(response.length > 0 && title != "" && fullName != "" && email != "" && numberPhone != "" &&  subject != "" && message != "") {
            $('.dev-form')[0].reset();
            $.ajax({
                type: 'POST',
                url: url,
                cache: false,
                data: {
                    '_token': _token,    
                    'title': title,
                    'fullName': fullName,
                    //'lastName': lastName,
                    //'ageGroup': ageGroup,
                    //'country': country,
                    'email': email,
                    //'areaCode': areaCode,
                    'numberPhone': validateNumberPhone,
                    'subject': subject,
                    'newsletter': newsletter,
                    'message': message
                },
                beforeSend: function () {
                    $('#overlay').fadeIn();
                    $('img.loading').fadeIn();
                },
                success: function (data) {
                    $('#overlay').fadeOut();
                    $('img.loading').fadeOut();
                    $('#successForm').modal('show'); 
                }
            }); 
        }else{
            $('#errorForm').modal('show'); 
        }
    });
    // Setup Phone Call Form Submit
    $(document).on("submit", "#setupCall-frm" , function(e){
        e.preventDefault(); 
        if($("input[name='mobileApp[]']").is(":checked")){
            var inputAcc = [];
            $("input[name='mobileApp[]']:checked").each( function(){
                var text = [];
                text.push($(this).val());
                text.push($(this).parents('li').find('input[type=text]').val()); 
                inputAcc.push(text); 
            });
            var mobileApp = JSON.stringify(inputAcc);
        }else{
           var mobileApp = ""; 
        }
        if($("input[name='timeSlot[]']").is(":checked")){
            var timeSlot = []
            $("input[name='timeSlot[]']:checked").each( function(){
                timeSlot.push($(this).val());
            });
        }else{
           var timeSlot = ""; 
        }
        var title = $("select[name=title]").find(":selected").val();
        var firstName = $("input[name=firstName]").val();
        var lastName = $("input[name=lastName]").val();
        var email = $("input[name=email]").val();
        var areaCode = $("select[name=areaCode]").find(":selected").val();
        var numberPhone = $("input[name=numberPhone]").val();
        if(numberPhone.charAt(0) == '0'){
            var validateNumberPhone = numberPhone.substr(1); 
        }else{
            var validateNumberPhone = numberPhone;
        }
        var ageGroup = $("select[name=ageGroup]").find(":selected").text();
        var country = $("select[name=country]").find(":selected").text();
        var subject = $("select[name=subject]").find(":selected").text();
        if($("input[name=newsletter]").is(':checked')){
            var newsletter = "Yes";
        }
        else{
            var newsletter = "No";
        }
        var titleIntro =  $("select[name=titleIntro]").find(":selected").val();
        var firstNameIntro = $("input[name=firstNameIntro]").val();        
        var lastNameIntro = $("input[name=lastNameIntro]").val();
        var appointmentDate = $("input[name=appointmentDate]").val();
        var timeZone = $("select[name=timeZone]").find(":selected").text();
        var url = $("input[name=url-frm]").val();
        var _token = $("input[name=_token]").val();
        var response = grecaptcha.getResponse();
        if(response.length === 0) {
            e.preventDefault();
            $(this).find('.g-recaptcha').addClass('error');
        } else {
            $(this).find('.g-recaptcha').removeClass('error');
        }
        if(response.length > 0 && title != "" && firstName != "" && lastName != ""  && email != "" && areaCode !="" && numberPhone != ""  && ageGroup != "" && country != ""
        &&  subject != "" && appointmentDate != "" && timeZone != "") {
            if(firstNameIntro != "" || lastNameIntro != "" || titleIntro != ""){
                $('.dev-form')[0].reset();
                $.ajax({
                    type: 'POST',
                    url: url,
                    cache: false,
                    data: {
                        '_token': _token,    
                        'title': title,
                        'firstName': firstName,
                        'lastName': lastName,
                        'ageGroup': ageGroup,
                        'country': country,
                        'email': email,
                        'areaCode': areaCode,
                        'numberPhone': validateNumberPhone,
                        'subject': subject,
                        'newsletter': newsletter,
                        'titleIntro': titleIntro,
                        'firstNameIntro': firstNameIntro,
                        'lastNameIntro': lastNameIntro,
                        'appointmentDate': appointmentDate,
                        'timeZone': timeZone,
                        'timeSlot': timeSlot,
                        'mobileApp': mobileApp,
                    },
                    beforeSend: function () {
                        $('#overlay').fadeIn();
                        $('img.loading').fadeIn();
                    },
                    success: function (data) {
                        $('#overlay').fadeOut();
                        $('img.loading').fadeOut();
                        $('#successForm').modal('show');
                    }
                });
            }else{
                $('.dev-form')[0].reset();
                $.ajax({
                    type: 'POST',
                    url: url,
                    cache: false,
                    data: {
                        '_token': _token,    
                        'title': title,
                        'firstName': firstName,
                        'lastName': lastName,
                        'ageGroup': ageGroup,
                        'country': country,
                        'email': email,
                        'areaCode': areaCode,
                        'numberPhone': validateNumberPhone,
                        'subject': subject,
                        'newsletter': newsletter,
                        'appointmentDate': appointmentDate,
                        'timeZone': timeZone,
                        'timeSlot': timeSlot,
                        'mobileApp': mobileApp,
                    },
                    beforeSend: function () {
                        $('#overlay').fadeIn();
                        $('img.loading').fadeIn();
                    },
                    success: function (data) {
                        $('#overlay').fadeOut();
                        $('img.loading').fadeOut();
                        $('#successForm').modal('show'); 
                    }
                });
            }   
        }else{
            $('#errorForm').modal('show'); 
        }
    });
    // Create My Trip Form Submit
    $(document).on("submit", "#createMyTrip-frm" , function(e){
        e.preventDefault(); 
        /*if($("input[name='mobileApp[]']").is(":checked")){
            var inputAcc = [];
            $("input[name='mobileApp[]']:checked").each( function(){
                var text = [];
                text.push($(this).val());
                text.push($(this).parents('li').find('input[type=text]').val()); 
                inputAcc.push(text); 
            });
            var mobileApp = JSON.stringify(inputAcc);
        }else{
           var mobileApp = ""; 
        }
        if($("input[name='timeSlot[]']").is(":checked")){
            var inputTimeSlot = []
            $("input[name='timeSlot[]']:checked").each( function(){
                inputTimeSlot.push($(this).val());
            });
            var timeSlot = JSON.stringify(inputTimeSlot);

        }else{
           var timeSlot = ""; 
        }*/
        if($("input[name='destination[]']").is(":checked")){
            var inputDest = []
            $("input[name='destination[]']:checked").each( function(){
                inputDest.push($(this).val());
            });
            var destination = JSON.stringify(inputDest);
        }else{
           var destination = ""; 
        }
        if($("input[name='tourType[]']").is(":checked")){
            var inputTourType = []
            $("input[name='tourType[]']:checked").each( function(){
                inputTourType.push($(this).val());
            });
            var tourType = JSON.stringify(inputTourType);
        }else{
           var tourType = ""; 
        }
        var title = $("select[name=title]").find(":selected").val();
        var fullName = $("input[name=fullName]").val();
        var email = $("input[name=email]").val();
        var numberPhone = $("input[name=numberPhone]").val();
        if(numberPhone.charAt(0) == '0'){
            var validateNumberPhone = numberPhone.substr(1); 
        }else{
            var validateNumberPhone = numberPhone;
        }
        var ageGroup = $("select[name=ageGroup]").find(":selected").text();
        if($("input[name=newsletter]").is(':checked')){
            var newsletter = "Yes";
        }
        else{
            var newsletter = "No";
        }
        var numAdult = $("select[id=numAdult]").find(":selected").val();
        var numChild = $("select[id=numChild]").find(":selected").val();
        var numBaby = $("select[id=numBaby]").find(":selected").val();
        var numTeenager = $("select[id=numTeenager]").find(":selected").val();
        var condition =  $("select[id=condition]").find(":selected").val();
        var physical = $("textarea[name=physical]").val();
        //var descProject = $("textarea[name=descProject]").val();
        var arrivalDate = $("input[name=arrivalDate]").val();
        var duration = $("select[name=duration]").val();
        var explainTrip = $("textarea[name=explainTrip]").val();
        var otherDest = $("textarea[name=otherDest]").val();
        var doubleRoom = $("select[name=doubleRoom]").val();
        var twinRoom = $("select[name=twinRoom]").val();
        var individualRoom = $("select[name=individualRoom]").val();
        var tripleRoom = $("select[name=tripleRoom]").val();
        if($('#frm-meals .checkbox').hasClass('active')){
            var meals = $("#frm-meals input[name=meals]:checked").val();
        }else{
            var meals = "";
        }
        var mealsTrips = $("textarea[name=mealsTrips]").val();
        var budgetPerson = $("input[name=budgetPerson]").val();
        var currencyPerson = $("select[name=currencyPerson]").find(":selected").val();
        var project = $("#frm-project input:checked").val();
        var accommodation = $("#frm-accommodation input[name=accommodation]:checked").val();
        var accommon = $("textarea[name=accommon]").val();
        //var furtherNote = $("textarea[name=furtherNote]").val();
        //var hobbies = $("textarea[name=hobbies]").val();
        //var lastLong = $("textarea[name=lastLong]").val();
        var canContact = $("input[name=canContact]:checked").val();
        var titleIntro =  $("select[name=titleIntro]").find(":selected").val();
        var fullNameIntro = $("input[name=fullNameIntro]").val();        
        //var appointmentDate = $("input[name=appointmentDate]").val();
        //var timeZone = $("select[name=timeZone]").find(":selected").text();
        var url = $("input[name=url-frm]").val();
        var _token = $("input[name=_token]").val();
        var response = grecaptcha.getResponse();
        if(response.length === 0) {
            e.preventDefault();
            $(this).find('.g-recaptcha').addClass('error');
        } else {
            $(this).find('.g-recaptcha').removeClass('error');
        }
        if(response.length > 0 && title != "" && fullName != "" && email != "" && ageGroup != "" && condition != "" && arrivalDate != "" && 
            duration != "" && destination != "" && tourType != "" && accommodation != "") {
            if(canContact == "Yes"){
                if(fullNameIntro != "" || titleIntro != ""){
                    $('.dev-form')[0].reset();
                    $.ajax({
                        type: 'POST',
                        url: url,
                        cache: false,
                        data: {
                            '_token': _token,    
                            'title': title,
                            'fullName': fullName,
                            'ageGroup': ageGroup,
                            'email': email,
                            'numberPhone': validateNumberPhone,
                            'newsletter': newsletter,
                            'destination' : destination,
                            'tourType' : tourType,
                            'project' : project,
                            'accommodation' : accommodation,
                            'accommon' : accommon,
                            //'furtherNote' : furtherNote,
                            'numAdult' : numAdult,
                            'numChild' : numChild, 
                            'numBaby' : numBaby,
                            'numTeenager' : numTeenager,
                            'condition' : condition,
                            'physical' : physical,
                            //'descProject' : descProject,
                            'meals': meals,
                            'mealsTrips' : mealsTrips,
                            'arrivalDate' : arrivalDate, 
                            'duration' : duration,
                            'explainTrip' : explainTrip,
                            'otherDest' : otherDest,
                            'doubleRoom' : doubleRoom,
                            'twinRoom' : twinRoom,
                            'individualRoom' : individualRoom,
                            'tripleRoom' : tripleRoom,
                            'budgetPerson' : budgetPerson,
                            'currencyPerson' : currencyPerson,
                            //'hobbies' : hobbies,
                            //'lastLong' : lastLong,
                            'canContact' : canContact,
                            'titleIntro': titleIntro,
                            'fullNameIntro': fullNameIntro,
                            /*'appointmentDate': appointmentDate,
                            'timeZone': timeZone,
                            'timeSlot': timeSlot,
                            'mobileApp': mobileApp*/
                        },
                        beforeSend: function () {
                            $('#overlay').fadeIn();
                            $('img.loading').fadeIn();
                        },
                        success: function (data) {
                            $('#overlay').fadeOut();
                            $('img.loading').fadeOut();
                            $('#successForm').modal('show'); 
                        }
                    });
                }else{
                    $('.dev-form')[0].reset();
                    $.ajax({
                        type: 'POST',
                        url: url,
                        cache: false,
                        data: {
                            '_token': _token,    
                            'title': title,
                            'fullName': fullName,
                            'ageGroup': ageGroup,
                            'email': email,
                            'numberPhone': validateNumberPhone,
                            'newsletter': newsletter,
                            'destination' : destination,
                            'tourType' : tourType,
                            'project' : project,
                            'accommodation' : accommodation,
                            'accommon' : accommon,
                            //'furtherNote' : furtherNote,
                            'numAdult' : numAdult,
                            'numChild' : numChild, 
                            'numBaby' : numBaby,
                            'numTeenager' : numTeenager,
                            'condition' : condition,
                            'physical' : physical,
                            //'descProject' : descProject,
                            'meals': meals,
                            'mealsTrips' : mealsTrips,
                            'arrivalDate' : arrivalDate, 
                            'duration' : duration,
                            'explainTrip' : explainTrip,
                            'otherDest' : otherDest,
                            'doubleRoom' : doubleRoom,
                            'twinRoom' : twinRoom,
                            'individualRoom' : individualRoom,
                            'tripleRoom' : tripleRoom,
                            'budgetPerson' : budgetPerson,
                            'currencyPerson' : currencyPerson,
                            //'hobbies' : hobbies,
                            //'lastLong' : lastLong,
                            'canContact' : canContact,
                            /*'appointmentDate': appointmentDate,
                            'timeZone': timeZone,
                            'timeSlot': timeSlot,
                            'mobileApp': mobileApp*/
                        },
                        beforeSend: function () {
                            $('#overlay').fadeIn();
                            $('img.loading').fadeIn();
                        },
                        success: function (data) {
                            $('#overlay').fadeOut();
                            $('img.loading').fadeOut();
                            $('#successForm').modal('show'); 
                        }
                    });
                }   
            }else if(canContact == "No"){
                $('.dev-form')[0].reset();
                $.ajax({
                    type: 'POST',
                    url: url,
                    cache: false,
                    data: {
                        '_token': _token,    
                        'title': title,
                        'fullName': fullName,
                        'ageGroup': ageGroup,
                        'email': email,
                        'numberPhone': validateNumberPhone,
                        'newsletter': newsletter,
                        'destination' : destination,
                        'tourType' : tourType,
                        'project' : project,
                        'accommodation' : accommodation,
                        'accommon' : accommon,
                        'numAdult' : numAdult,
                        'numChild' : numChild, 
                        'numBaby' : numBaby,
                        'numTeenager' : numTeenager,
                        'condition' : condition,
                        'physical' : physical,
                        'meals': meals,
                        'mealsTrips' : mealsTrips,
                        'arrivalDate' : arrivalDate, 
                        'duration' : duration,
                        'explainTrip' : explainTrip,
                        'otherDest' : otherDest,
                        'doubleRoom' : doubleRoom,
                        'twinRoom' : twinRoom,
                        'individualRoom' : individualRoom,
                        'tripleRoom' : tripleRoom,
                        'budgetPerson' : budgetPerson,
                        'currencyPerson' : currencyPerson,
                        'canContact' : canContact,
                    },
                    beforeSend: function () {
                        $('#overlay').fadeIn();
                        $('img.loading').fadeIn();
                    },
                    success: function (data) {
                        $('#overlay').fadeOut();
                        $('img.loading').fadeOut();
                        $('#successForm').modal('show'); 
                    }
                });
            }else{
                $('#errorForm').modal('show'); 
            }
        }else{
            $('#errorForm').modal('show'); 
        }
    });
    // Personal Form Submit
    $(document).on("submit", "#personalize-frm" , function(e){
        e.preventDefault();  
        var title = $("select[name=title]").find(":selected").val();
        var fullName = $("input[name=fullName]").val();
        var email = $("input[name=email]").val();
        var numberPhone = $("input[name=numberPhone]").val();
        if(numberPhone.charAt(0) == '0'){
            var validateNumberPhone = numberPhone.substr(1); 
        }else{
            var validateNumberPhone = numberPhone;
        }
        var ageGroup = $("select[name=ageGroup]").find(":selected").text();
        if($("input[name=newsletter]").is(':checked')){
            var newsletter = "Yes";
        }
        else{
            var newsletter = "No";
        }
        var numAdult = $("select[id=numAdult]").find(":selected").val();
        var numChild = $("select[id=numChild]").find(":selected").val();
        var numBaby = $("select[id=numBaby]").find(":selected").val();
        var numTeenager = $("select[id=numTeenager]").find(":selected").val();
        var condition =  $("select[id=condition]").find(":selected").val();
        var physical = $("textarea[name=physical]").val();
        var arrivalDate = $("input[name=arrivalDate]").val();
        var duration = $("select[name=duration]").val();
        var explainTrip = $("textarea[name=explainTrip]").val();
        var otherDest = $("textarea[name=otherDest]").val();
        var doubleRoom = $("select[name=doubleRoom]").val();
        var twinRoom = $("select[name=twinRoom]").val();
        var individualRoom = $("select[name=individualRoom]").val();
        var tripleRoom = $("select[name=tripleRoom]").val();
        if($('#frm-meals .checkbox').hasClass('active')){
            var meals = $("#frm-meals input[name=meals]:checked").val();
        }else{
            var meals = "";
        }
        var mealsTrips = $("textarea[name=mealsTrips]").val();
        var budgetPerson = $("input[name=budgetPerson]").val();
        var currencyPerson = $("select[name=currencyPerson]").find(":selected").val();
        var project = $("#frm-project input:checked").val();
        var accommodation = $("#frm-accommodation input[name=accommodation]:checked").val();
        var accommon = $("textarea[name=accommon]").val();
        var canContact = $("input[name=canContact]:checked").val();
        var titleIntro =  $("select[name=titleIntro]").find(":selected").val();
        var fullNameIntro = $("input[name=fullNameIntro]").val();

        var url = $("input[name=url-frm]").val();
        var _token = $("input[name=_token]").val();
        var response = grecaptcha.getResponse();
        if(response.length === 0) {
            e.preventDefault();
            $(this).find('.g-recaptcha').addClass('error');
        } else {
            $(this).find('.g-recaptcha').removeClass('error');
        }
        if(response.length > 0 && title != "" && fullName != "" && email != "" && ageGroup != "" && condition != "" && arrivalDate != "" && duration != ""  && accommodation != "") {
            if(canContact == "Yes"){
                if(fullNameIntro != "" || titleIntro != ""){
                    $('.dev-form')[0].reset();
                    $.ajax({
                        type: 'POST',
                        url: url,
                        cache: false,
                        data: {
                            '_token': _token,    
                            'title': title,
                            'fullName': fullName,
                            'ageGroup': ageGroup,
                            'email': email,
                            'numberPhone': validateNumberPhone,
                            'newsletter': newsletter,
                            'project' : project,
                            'accommodation' : accommodation,
                            'accommon' : accommon,
                            'numAdult' : numAdult,
                            'numChild' : numChild, 
                            'numBaby' : numBaby,
                            'numTeenager' : numTeenager,
                            'condition' : condition,
                            'physical' : physical,
                            'meals': meals,
                            'mealsTrips' : mealsTrips,
                            'arrivalDate' : arrivalDate, 
                            'duration' : duration,
                            'explainTrip' : explainTrip,
                            'otherDest' : otherDest,
                            'doubleRoom' : doubleRoom,
                            'twinRoom' : twinRoom,
                            'individualRoom' : individualRoom,
                            'tripleRoom' : tripleRoom,
                            'budgetPerson' : budgetPerson,
                            'currencyPerson' : currencyPerson,
                            'canContact' : canContact,
                            'titleIntro': titleIntro,
                            'fullNameIntro': fullNameIntro,
                        },
                        beforeSend: function () {
                            $('#overlay').fadeIn();
                            $('img.loading').fadeIn();
                        },
                        success: function (data) {
                            $('#overlay').fadeOut();
                            $('img.loading').fadeOut();
                            $('#successForm').modal('show'); 
                        }
                    });
                }else{
                    $('.dev-form')[0].reset();
                    $.ajax({
                        type: 'POST',
                        url: url,
                        cache: false,
                        data: {
                            '_token': _token,    
                            'title': title,
                            'fullName': fullName,
                            'ageGroup': ageGroup,
                            'email': email,
                            'numberPhone': validateNumberPhone,
                            'newsletter': newsletter,
                            'project' : project,
                            'accommodation' : accommodation,
                            'accommon' : accommon,
                            'numAdult' : numAdult,
                            'numChild' : numChild, 
                            'numBaby' : numBaby,
                            'numTeenager' : numTeenager,
                            'condition' : condition,
                            'physical' : physical,
                            'meals': meals,
                            'mealsTrips' : mealsTrips,
                            'arrivalDate' : arrivalDate, 
                            'duration' : duration,
                            'explainTrip' : explainTrip,
                            'otherDest' : otherDest,
                            'doubleRoom' : doubleRoom,
                            'twinRoom' : twinRoom,
                            'individualRoom' : individualRoom,
                            'tripleRoom' : tripleRoom,
                            'budgetPerson' : budgetPerson,
                            'currencyPerson' : currencyPerson,
                            'canContact' : canContact,
                            'titleIntro': titleIntro,
                            'fullNameIntro': fullNameIntro,
                        },
                        beforeSend: function () {
                            $('#overlay').fadeIn();
                            $('img.loading').fadeIn();
                        },
                        success: function (data) {
                            $('#overlay').fadeOut();
                            $('img.loading').fadeOut();
                            $('#successForm').modal('show'); 
                        }
                    });
                }   
            }else if(canContact == "No"){
                $('.dev-form')[0].reset();
                $.ajax({
                    type: 'POST',
                    url: url,
                    cache: false,
                    data: {
                        '_token': _token,    
                        'title': title,
                        'fullName': fullName,
                        'ageGroup': ageGroup,
                        'email': email,
                        'numberPhone': validateNumberPhone,
                        'newsletter': newsletter,
                        'project' : project,
                        'accommodation' : accommodation,
                        'accommon' : accommon,
                        'numAdult' : numAdult,
                        'numChild' : numChild, 
                        'numBaby' : numBaby,
                        'numTeenager' : numTeenager,
                        'condition' : condition,
                        'physical' : physical,
                        'meals': meals,
                        'mealsTrips' : mealsTrips,
                        'arrivalDate' : arrivalDate, 
                        'duration' : duration,
                        'explainTrip' : explainTrip,
                        'otherDest' : otherDest,
                        'doubleRoom' : doubleRoom,
                        'twinRoom' : twinRoom,
                        'individualRoom' : individualRoom,
                        'tripleRoom' : tripleRoom,
                        'budgetPerson' : budgetPerson,
                        'currencyPerson' : currencyPerson,
                        'canContact' : canContact,
                        'titleIntro': titleIntro,
                        'fullNameIntro': fullNameIntro,
                    },
                    beforeSend: function () {
                        $('#overlay').fadeIn();
                        $('img.loading').fadeIn();
                    },
                    success: function (data) {
                        $('#overlay').fadeOut();
                        $('img.loading').fadeOut();
                        $('#successForm').modal('show'); 
                    }
                });
            }else{
                $('#errorForm').modal('show'); 
            }
        }else{
            $('#errorForm').modal('show'); 
        }
    });
    $(document).on("submit", "#feedbeck-frm" , function(e){
        e.preventDefault(); 
        if($("input[name='destination[]']").is(":checked")){
            var inputDest = []
            $("input[name='destination[]']:checked").each( function(){
                inputDest.push($(this).val());
            });
            var destination = JSON.stringify(inputDest);
        }else{
           var destination = ""; 
        }
        if($("input[name='about_us[]']").is(":checked")){
            var inputAbout = []
            $("input[name='about_us[]']:checked").each( function(){
                inputAbout.push($(this).val());
            });
            var about_us = JSON.stringify(inputAbout);
        }else{
           var about_us = ""; 
        }
        var title = $("select[name=title]").find(":selected").val();
        var fullName = $("input[name=fullName]").val();
        var email = $("input[name=email]").val();
        var numberPhone = $("input[name=numberPhone]").val();
        if(numberPhone.charAt(0) == '0'){
            var validateNumberPhone = numberPhone.substr(1); 
        }else{
            var validateNumberPhone = numberPhone;
        }
        var code = $("select[id=code]").find(":selected").val();
        var fromPeriodDate = $("input[name=fromPeriodDate]").val();
        var toPeriodDate = $("input[name=toPeriodDate]").val();
        var knowledge = $("input[id=knowledge-score]").val();
        var helpfulness = $("input[id=helpfulness-score]").val();
        var courteousness = $("input[id=courteousness-score]").val();
        var attr_items = new Array();
            var number = 1;
            $("#frm-feedback-rpt .sortable .guide-number").each(function(){
                var guide = $(this).find(".guide-1 input[name=guide]").val();
                var places = $(this).find(".guide-1 input[name=places]").val();
                var fromGuideDate = $(this).find(".date-1 input[name=fromGuideDate]").val();
                var toGuideDate = $(this).find(".date-1 input[name=toGuideDate]").val();
                var language = $(this).find(".raty-1 input[name=language-score]").val();
                var knowlg = $(this).find(".raty-2 input[name=knowlg-score]").val();
                var explanation = $(this).find(".raty-3 input[name=explanation-score]").val();
                var attitude = $(this).find(".raty-4 input[name=attitude-score]").val();
                attr_items[number] = {
                    'guide' : guide,
                    'places' : places,
                    'fromGuideDate' : fromGuideDate,
                    'toGuideDate' : toGuideDate,
                    'language' : language,
                    'knowlg' : knowlg,
                    'explanation' : explanation,
                    'attitude' : attitude,
                }
                number++;
       }); 
        var organization = $("input[id=organization-score]").val();
        var flexibility = $("input[id=flexibility-score]").val();
        var rhythm = $("input[id=rhythm-score]").val();

        var attr_hottel = new Array();
            var number = 1;
            $("#frm-hottel-rpt .sortable .hottel-number").each(function(){
                var accommodation = $(this).find(".accommos-1 input[name=accommodation]").val();
                var city = $(this).find(".accommos-1 input[name=city]").val();
                var fromAccomDate = $(this).find(".accomDate-1 input[name=fromAccomDate]").val();
                var toAccomDate = $(this).find(".accomDate-1 input[name=toAccomDate]").val();
                var comfort = $(this).find(".review-1 input[name=comfort-score]").val();
                var location = $(this).find(".review-2 input[name=location-score]").val();
                var cleanliness = $(this).find(".review-3 input[name=cleanliness-score]").val();
                var facilities = $(this).find(".review-4 input[name=facilities-score]").val();
                var staffs = $(this).find(".review-5 input[name=staffs-score]").val();
                var breakfast = $(this).find(".review-6 input[name=breakfast-score]").val();
                attr_hottel[number] = {
                    'guide' : guide,
                    'places' : places,
                    'fromGuideDate' : fromGuideDate,
                    'toGuideDate' : toGuideDate,
                    'language' : language,
                    'knowlg' : knowlg,
                    'explanation' : explanation,
                    'attitude' : attitude,
                }
                number++;
       }); 
        var driver = $("input[id=driver-score]").val();
        var safety = $("input[id=safety-score]").val();
        var comfort_vp = $("input[id=comfort_vp-score]").val();
        var food = $("input[id=food-score]").val();
        var service = $("input[id=service-score]").val();
        var atmosphere = $("input[id=atmosphere-score]").val();
        var specify = $("textarea[name=specify]").val();
        var comments = $("textarea[name=comments]").val();
        var upload_files = $("input[name=upload-files]").val();
        if($("input[name=newsletter]").is(':checked')){
            var newsletter = "Yes";
        }
        else{
            var newsletter = "No";
        }
        var url = $("input[name=url-frm]").val();
        var _token = $("input[name=_token]").val();
        var response = grecaptcha.getResponse();
        if(response.length === 0) {
            e.preventDefault();
            $(this).find('.g-recaptcha').addClass('error');
        } else {
            $(this).find('.g-recaptcha').removeClass('error');
        }
        if(response.length > 0 && title != "" && fullName != "" && email != "") {
            $('.dev-form')[0].reset();
            $.ajax({
                type: 'POST',
                url: url,
                cache: false,
                data: {
                    '_token': _token,    
                    'title': title,
                    'fullName': fullName,
                    'email': email,
                    'numberPhone': validateNumberPhone,
                    'newsletter': newsletter,
                    'destination' : destination,
                    'about_us' : about_us,
                    'code' : code,
                    'fromPeriodDate' : fromPeriodDate,
                    'toPeriodDate' : toPeriodDate,
                    'knowledge' : knowledge,
                    'helpfulness' : helpfulness,
                    'courteousness' : courteousness,
                    'attr_items' : attr_items,
                    'organization' : organization,
                    'flexibility' : flexibility,
                    'rhythm' : rhythm,
                    'accommodation' : accommodation,
                    'city' : city,
                    'fromAccomDate' : fromAccomDate,
                    'toAccomDate' : toAccomDate,
                    'comfort' : comfort,
                    'location' : location,
                    'cleanliness' : cleanliness,
                    'facilities' : facilities,
                    'staffs' : staffs,
                    'breakfast' : breakfast,
                    'attr_hottel' : attr_hottel,
                    'safety' : safety,
                    'comfort_vp' : comfort_vp,
                    'food' : food,
                    'service' : service,
                    'atmosphere' : atmosphere,
                    'specify' : specify,
                    'comments' : comments,
                    'upload_files' : upload_files,
                    'newsletter' : newsletter,    
                },
                beforeSend: function () {
                    $('#overlay').fadeIn();
                    $('img.loading').fadeIn();
                },
                success: function (data) {
                    $('#overlay').fadeOut();
                    $('img.loading').fadeOut();
                    $('#successForm').modal('show'); 
                }
            });
        }else{
            $('#errorForm').modal('show'); 
        }
    });
    // Click show search form blog
    $('.header-blog').on('click','.search', function(){
        $(this).parents('.frm-search').find('.show-search').slideToggle();
    });

    // Show menu table of content
    $('.menu-wrap .collap a').on("click", function(e){
        e.preventDefault();
        $(this).parent(".collap").addClass("hidden");
        $(".menu-wrap .expand").removeClass("hidden");
        $(this).parents("h2").siblings("ul").removeClass("in");
    });
    $('.menu-wrap .expand a').on("click", function(e){
        e.preventDefault();
        $(this).parent(".expand").addClass("hidden");
        $(".menu-wrap .collap").removeClass("hidden");
        $(this).parents("h2").siblings("ul").addClass("in");
    });
    $(".menu-wrap ul li").find("a").on("click", function(e){
        e.preventDefault();
        $([document.documentElement, document.body]).animate({
            scrollTop: $($(this).attr('href')).offset().top - 50
        },'normal', function(){
            $('html, body').removeClass('scrolling');
            $(e.target).removeClass('scrolling');
        });
    });
    
});