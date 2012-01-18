$(init);

var advice = {};
var prevAdvices = [];
var rand = -1;
var infoOpen = false;

function init(){
	$.getJSON('get.php', function(data){
		advice = data.advice;
		pageController();
		setEventListeners();
	}); 
}


function setEventListeners(){
	$(window).on('keydown', keyController);
	$('.arrow').on('click', showInfo);
	$('textarea').on('keyup', adviceTextHandler);
	$('.submit').on('click', submitAdvice);
}


function submitAdvice(){
	var txt = $('textarea').val();
	if(txt.length < 5 || txt.length > 70){
		return;
	}
	$.post('add.php',{advice:txt}, function(data) {
		if(data == "ok"){
			alert("added");
		}
	});
}


function adviceTextHandler(e){
	var length = $('textarea').val().length;
	if(length > 70) { 
		$('textarea').val($('textarea').val().substr(0, 70)); 
		return; 
	}
	$('.counter span').html(length);
	$('.progress').width(length*(220/70));
}


function keyController(e){
	if(e.keyCode == 39 || e.keyCode == 38){
		getRandomAdvice();
	}
	if(e.keyCode == 37 || e.keyCode == 36){
		getPrevAdvice();
	}
}


function showInfo(){
	infoOpen = !infoOpen;
	if(infoOpen){
		$('#info-box').animate({top:0}, {duration:300});
		$('#main').animate({paddingTop:170}, {duration:300});
		$('.arrow').animate({top:170}, {duration:300});
		$('.arrow .arr').addClass("up");
	}else{
		$('#info-box').animate({top:-165}, {duration:300});
		$('#main').animate({paddingTop:0}, {duration:300});
		$('.arrow').animate({top:5}, {duration:300});
		$('.arrow .arr').removeClass("up");
	}
	
}

function pageController(){
	$.history.init(function(hash){
        if(hash != "") {
            hash = hash.substr(1, hash.length);
        	showAdvice(hash);
        }else{
        	getRandomAdvice();
        }
    },
    { unescape: ",/" });
}


function getRandomAdvice(){
	var found = false;
	rand = Math.floor(Math.random()*advice.length);
	if(prevAdvices.length == 0){
		window.location = '#/'+advice[rand].url;
	}
	if(prevAdvices.length == advice.length){
		prevAdvices = [rand];
	}
	$(prevAdvices).each(function(i, a){
		if(a == rand){
			found = true;
		}
		if(i == prevAdvices.length - 1){
			if(found){
				getRandomAdvice();
			}else{
				//prevAdvices.push(rand);
				window.location = '#/'+advice[rand].url;	
			}
		}
	});
}

function getPrevAdvice(){
	history.go(-1);
}


function showAdvice(url){
	
	$(advice).each(function(i, a){
		if(a.url === url || a.id == url){
			$('h2#advice').html(a.text);
			prevAdvices.push(i);
			return;
		}
	});
	
	
}