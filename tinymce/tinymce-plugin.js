(function() {
	

    tinymce.create('tinymce.plugins.Shortcodes', {

        init : function(ed, url) {
        },
        createControl : function(n, cm) {

            if(n=='Shortcodes'){
                var mlb = cm.createListBox('SE_Albums', {
                     title : 'SE Albums',
                     onselect : function(v) {
                        if(tinyMCE.activeEditor.selection.getContent() == ''){
                            tinyMCE.activeEditor.selection.setContent( v )
                        }

                     }
                });


                // Add some menu items
                var my_shortcodes = [];
                
                /* --------------------------------------------------------- */
                
				var album_data = {};
				
				var xmlhttp;
				if (window.XMLHttpRequest)
				  {// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				    {
				    	album_data = JSON.parse(xmlhttp.responseText);
						
						mlb.add( 'Auto Player',         '[SE_album_player album_id=autoplayer]');
						mlb.add( 'Auto Player [DL]',         '[SE_album_player album_id=autoplayer dl=true]');
				    	for (var key in album_data) {
						  if (album_data.hasOwnProperty(key)) {
						    
						    mlb.add( album_data[key],         '[SE_album_player album_id='+key+']');
						    mlb.add( album_data[key] + ' [DL]',         '[SE_album_player album_id='+key+' dl=true]');
						  }
						}

				    }
				  }
				xmlhttp.open("GET","/wp-admin/admin-ajax.php?action=get_se_album_list",true);
				xmlhttp.send();
                
                
				                
                
                /* --------------------------------------------------------- */
                

                for(var i in album_data)
                    mlb.add(album_data[i],album_data[i]);

                return mlb;
            }
            return null;
        }


    });
    tinymce.PluginManager.add('Shortcodes', tinymce.plugins.Shortcodes);
})();