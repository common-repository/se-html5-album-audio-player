jQuery(document).ready(function($){


/* --------------------------------------------------------- */
		
	$('.se_albumplayer').each(function(e){
		

		var playerWrap = $(this);
		var albumID = playerWrap.find('.controls').attr('id').replace('controls-', '');

		var audioElement = playerWrap.find('audio');
		var playlistWrap = playerWrap.find('.playlistWrap');
		var tracks = playerWrap.find('.tracks');
		var firstTrack = playerWrap.find('.tracks .track:first');
		var currentTrack = firstTrack;
		var trackInfo = playerWrap.find('.trackInfo');

		var coverImg = playerWrap.find('.cover');
		
		audioElement.attr('src', firstTrack.attr('data-track_src') );
		trackInfo.html( firstTrack.find('.track_title').html() );
		firstTrack.addClass('current');
		
		var audioObject = audioElement.get(0);
		var playBtn = playerWrap.find('.playPauseBtn');
		var barBox = playerWrap.find('.progressBar');
		
		var trackInfo = playerWrap.find('.trackInfo');
		
		var timeCode = playerWrap.find('.timeCode');
		
		var progressContainer = playerWrap.find('.progress');
		var progressBar = playerWrap.find('.progress .bar.playBar');
		var loadBar = playerWrap.find('.progress .bar.loadBar');
		var seekBar = playerWrap.find('.progress .bar.seekBar');
		var seekData = {};
		
		var playlistBtn = playerWrap.find('.playlistBtn.icon-list');

		
		var seekFwdBtn = playerWrap.find('.seekBtn.icon-fast-forward');
		var seekBckBtn = playerWrap.find('.seekBtn.icon-fast-backward');
		
		var volumeBtn = playerWrap.find('td.volume .volumeBtn');
		var volumeBarWrap = playerWrap.find('.progress.volume');
		var volumeBar = playerWrap.find('.progress.volume .bar.volumeBar');
		
		//download
		var idown;  // Keep it outside of the function, so it's initialized once.
		function downloadURL(url) {
		  if (idown) {
		    idown.attr('src',url);
		  } else {
		    idown = $('<iframe>', { id:'idown', src:url }).hide().appendTo('body');
		  }
		}
		
		
		/* --------------------------------------------------------- */
		
		
		
		
		var audioTag = document.createElement('audio');
		if (!(!!(audioTag.canPlayType) && ("no" != audioTag.canPlayType("audio/mpeg")) && ("" != audioTag.canPlayType("audio/mpeg")))) {
		// 
		
			$.getScript("/wp-content/plugins/se-html5-album-audio-player/js/niftyplayer/niftyplayer.js", function(data, textStatus, jqxhr) {
				
	
				var niftyPlayerID = 'niftyPlayer-'+albumID;
				
				var audioSrc = audioElement.attr('src');
				
				var flashObject = '<div class="flashTrack" style="position:absolute"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="0" height="0" id="'+niftyPlayerID+'" align=""><param name=movie value="niftyplayer.swf?file=betty.mp3&as=0"><param name=quality value=high><param name=bgcolor value=#FFFFFF><embed src="/wp-content/plugins/se-html5-album-audio-player/js/niftyplayer/niftyplayer.swf?file='+audioSrc+'&as=0" quality=high bgcolor=#FFFFFF width="0" height="0" name="'+niftyPlayerID+'" align="" type="application/x-shockwave-flash" swLiveConnect="true" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object></div>';
			
				playerWrap.find('.controls').append(flashObject);
				playerWrap.find('td.bars').remove();
				playerWrap.find('td.volume').remove();
				
				var niftyeq = '<td class="niftyeq"><div class="display"></div></td>';
				
				playerWrap.find('td.time').replaceWith(niftyeq);
				
				
				
				//playBtn
				playBtn.click(function(){
					checkNiftyStatus(niftyPlayerID);	
					niftyplayer(niftyPlayerID).playToggle();
					
					playerWrap.find('td.niftyeq .display').toggleClass('pound');
					playBtn.toggleClass('icon-pause');
					playBtn.toggleClass('icon-play');
					
				});
				
				/* --------------------------------------------------------- */
				//PLaylist
				
				playlistBtn.click(function(){
					playlistWrap.slideToggle();
				});
				
	
				playlistWrap.find('.track .track_title, .track .track_order').click(function(){
								
					changeTrack($(this).parent());

					playlistWrap.delay(500).slideToggle();
	
				});
				
				playlistWrap.find('.track td.downloadBtn').click(function(){
					downloadURL('/wp-content/plugins/se-html5-album-audio-player/download_audio.php' + '?file=' + $(this).parent().attr('data-track_src').replace(/https?:\/\/[^\/]+/i, ""));
				});
						
				/* --------------------------------------------------------- */
				
				//seekBtn
				seekFwdBtn.click(function(){
	
					var target = currentTrack.next('.track');
					if(target.length){
						changeTrack(target);
					}
									
				});
				
				seekBckBtn.click(function(){
					
					var target = currentTrack.prev('.track');
					if(target.length){
						changeTrack(target);
					}
					
				});
				
				function changeTrack(targetTrack){
					
					currentTrack.removeClass('current');
					currentTrack = targetTrack;
					currentTrack.addClass('current');
					
					var playerState = niftyplayer(niftyPlayerID).getState();
					
					trackInfo.html( targetTrack.find('.track_title').html()  );
					adjust_marquee(playerWrap.find('.marquee'));
					playerWrap.find('.marquee .sections').css('margin-top', '-1em');
										
					if ( playerState != 'paused' && playerState != 'empty' ){
						niftyplayer(niftyPlayerID).stop();
						niftyplayer(niftyPlayerID).loadAndPlay(targetTrack.attr('data-track_src'));
					} else {
						niftyplayer(niftyPlayerID).stop();
						niftyplayer(niftyPlayerID).load(targetTrack.attr('data-track_src'));
					}
				}
				
				/* --------------------------------------------------------- */
				// poll player state
				
				var pollInterval = 0;
				// STARTS and Resets the loop if any
				function checkNiftyStatus(playerId) {
				    if(pollInterval > 0) clearInterval(pollInterval);  // stop
				    pollInterval = setInterval( function(){
				    	
				    	var playerState = niftyplayer(playerId).getState();
					    
					    console.log(playerState);
					    
					    if(playerState == 'finished'){
					    	var target = currentTrack.next('.track');
							if(target.length){
								changeTrack(target);
							}
					    }
				    
				    }, 1600 );  // run
				}

								
				
				/* --------------------------------------------------------- */
				
				
				
			});
								
		} else {
		//HTML5
			/* --------------------------------------------------------- */
			//PLaylist
			
			playlistBtn.click(function(){
				playlistWrap.slideToggle();
			});
			

			playlistWrap.find('.track .track_title, .track .track_order').click(function(){
								
				changeTrack($(this).parent());
				
				audioObject.play();
				playBtn.addClass('icon-pause');
				playBtn.removeClass('icon-play');
				

				playlistWrap.delay(500).slideToggle();

			});
			
			playlistWrap.find('.track td.downloadBtn').click(function(){
				downloadURL('/wp-content/plugins/se-html5-album-audio-player/download_audio.php' + '?file=' + $(this).parent().attr('data-track_src').replace(/https?:\/\/[^\/]+/i, ""));			
			});

			/* --------------------------------------------------------- */
			//seekBtn
			seekFwdBtn.click(function(){

				var target = currentTrack.next('.track');
				if(target.length){
					changeTrack(target);
				}
								
			});
			
			seekBckBtn.click(function(){
				
				var target = currentTrack.prev('.track');
				if(target.length){
					changeTrack(target);
				}
				
			});
			
			function changeTrack(targetTrack, forcePlay){
				
				currentTrack.removeClass('current');
				currentTrack = targetTrack;
				currentTrack.addClass('current');
				
				var isPaused = audioObject.paused;
				
				audioElement.attr('src', targetTrack.attr('data-track_src') );
				trackInfo.html( targetTrack.find('.track_title').html()  );
				adjust_marquee(playerWrap.find('.marquee'));
				audioObject.load();	

				if ( !isPaused || forcePlay ){
					audioObject.play();
				}
			}
			
			
			/* --------------------------------------------------------- */
			//Volume
			
			volumeBtn.click(function(){
				volumeBarWrap.toggle();

			});
			
			volumeBarWrap.click(function(e){
			
				var offset = $(this).offset(); 
				var marginTop = $(this).css('margin-top').replace('px', '');
				
				var volumeNum = $(this).position().top + volumeBarWrap.outerHeight(true) ;
                volumeNum = Math.abs(e.pageY - volumeNum);
                
                if(volumeNum > 100) {volumeNum = 100;}
                
                if(volumeNum <= 5) {
                	volumeNum = 0;
                	volumeBtn.removeClass('icon-volume-up');
                	volumeBtn.addClass('icon-volume-off');
                } else  {
                	volumeBtn.removeClass('icon-volume-off');
                	volumeBtn.addClass('icon-volume-up');
                }

	            volumeBar.css({'height' : volumeNum + '%'});  
	            audioObject.volume = volumeNum/100;  	
			});
			
				
			/* --------------------------------------------------------- */
			//marquee	
			var marqueeFactor  =  playerWrap.innerWidth() / 220;
			
			if(trackInfo.html() == ''){
				trackInfo.hide();
			}else {
				if( (trackInfo.outerWidth(true) + 50) > playerWrap.innerWidth() ){
					$('.marquee').simplemarquee({
						speed: 		(5000 ) ,
						direction: 	'rtl',
						pause: 		false
					});
				}
			}
			
			/* --------------------------------------------------------- */
			
			progressBar.progressbar({
				use_percentage: false,
                display_text: 2,
			});
			loadBar.progressbar({
				use_percentage: false
			});
			
			/* --------------------------------------------------------- */
			//styling
			
			/* --------------------------------------------------------- */
			//playBtn
			playBtn.click(function(){
							
				if (audioObject.paused) {
				   audioObject.play();
				} else {
				   audioObject.pause();
				}
				
				playBtn.toggleClass('icon-pause');
				playBtn.toggleClass('icon-play');
			});
			/* --------------------------------------------------------- */
			//progress bar

			audioElement.bind('timeupdate', playbackProgress );
	        
	        function playbackProgress(){
	        	var track_length = audioObject.duration;
	        	var secs = audioObject.currentTime;
	            var progress = (secs/track_length) * 100;

	            progressBar.css({'width' : progress + "%"});
	            
	            var tcMins = parseInt(secs/60);
	            var tcSecs = parseInt(secs - (tcMins * 60));
	            
	            var durMins = parseInt(track_length/60);
	            var durSecs = parseInt(track_length - (durMins * 60));
	
	            if (tcSecs < 10) { tcSecs = '0' + tcSecs; }
				if (durSecs < 10) { durSecs = '0' + durSecs; }
	            
	            if( isNaN(track_length )){
	        		timeCode.html( tcMins + ':' + tcSecs + '/' + '0:00');
	        	} else {
	            	timeCode.html( tcMins + ':' + tcSecs + '/' + durMins + ':' + durSecs);
	        	}
	            

	            if(audioObject.ended){
	            	
	            	var target = currentTrack.next('.track');
					if(target.length){
						changeTrack(target, true);
					} else {
						playBtn.removeClass('icon-pause');
	            		playBtn.addClass('icon-play');
					}
	            
	            	
	            }

	        
	        }
	        
	        
	        /* --------------------------------------------------------- */
	        // Load Progress =====================//
	
			audioElement.bind("progress", function() {
				updateLoadBar();
			});

			
			audioElement.bind("ended", function() {
			});

			audioElement.bind("loadeddata", function() {
				updateLoadBar();
			});
			audioElement.bind("loadstart", function() {
				updateLoadBar();
			});
			audioElement.bind("canplaythrough", function() {
				updateLoadBar();
								playbackProgress();

			});
			audioElement.bind("playing", function() {
				updateLoadBar();
			});
				
			
			function updateLoadBar(){
			
				if( (audioObject.buffered != undefined) && (audioObject.buffered.length != 0) && (!audioObject.paused) ) {
					var percent = (audioObject.buffered.end(0) / audioObject.duration) * 100;	
					
					loadBar.css({ 'width': percent + "%" });
					seekBar.css({ 'width': percent + "%" });
				} else if( audioObject.buffered.length == 0 ) {
					loadBar.css({ 'width': 0 + "%" });
					seekBar.css({ 'width': 0 + "%" });
				}
				
			}
			/* --------------------------------------------------------- */
			//seek bar
			

	       // audioObject.ondurationchange = setupSeekbar;
	
	        function seekAudio(goTo) {
	          	audioObject.currentTime = goTo;
	        }
	
	       	        
	        seekBar.click(function(e){
	        	
	        	var offset = $(this).offset();   			
	   			
	            var seekPercent = (e.clientX - offset.left) / (progressContainer.outerWidth());        	
	       		var seekTo = seekPercent * audioObject.duration ;
	       		seekAudio( seekTo );
	       		
	        });

		} // end ELSE for HTML5
		
	});
	
/* --------------------------------------------------------- */

});



/* ========================================== */
/* resize */
/* ========================================== */



jQuery(window).smartresize(function($) {
	adjust_marquees();
});



/* ========================================== */
/* functions */
/* ========================================== */

function adjust_marquees(){
	jQuery('.marquee').each(function(){
		adjust_marquee(jQuery(this));
	});
}

function adjust_marquee(marquee){
	var marqueeObj = marquee;
	var playerWrap = marqueeObj.closest('.se_albumplayer');
	var trackInfo = playerWrap.find('.trackInfo');
	
	var thisTxt = marqueeObj.find('.sections .section:first').html();
	marqueeObj.find('.sections').remove();
	marqueeObj.html(thisTxt);
	
	if( (marqueeObj.outerWidth(true) + 50) > playerWrap.innerWidth()  ){
		trackInfo.show();
		
		marqueeObj.simplemarquee({
			speed: 		10000 ,
			direction: 	'rtl', // Options "ltr" or "rtl"
			pause: 		false
		});
	}
}


/* --------------------------------------------------------- */
//animate

jQuery.fn.animateHighlight = function(highlightColor, duration) {
    var highlightBg = highlightColor || "#FFFF9C";
    var animateMs = duration || 1500;
    var originalBg = this.css("backgroundColor");
    this.stop().css("background-color", highlightBg).animate({backgroundColor: originalBg}, animateMs);
};
