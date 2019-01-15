var mydata = ({
	check : function ( data ) {
		$.each ( data, function ( i,j ) {
			var themeid = $("#salon_theme").val();
			var photolimit = $("#mtheme"+themeid).val();
			
			if ( j.imgnum >= 0 ) {
				imgleft = parseInt ( photolimit - j.imgnum );
				if ( imgleft > 0 ) {
					if ( j.imgnum == 0 ) {
						var info = $("<p />", {
							text : 'You can upload '+imgleft+' image(s) in this section.'
						});
					} else {
						var info = $("<p />", {
							text : 'Now you can upload '+imgleft+' more image(s) in this section.'
						});
					}
					$("#info").html ( info );
					$('#cont').slideDown();
				} else {
					var info = $("<p />", {
						text : 'No more upload in this section.'
					});
					$("#info").html ( info );
					$('#cont').slideUp();
				}
			}
		});
	},
	imageShow : function ( data ) {
		$("#disp").html('');
		$ . each ( data, function ( i, j ) {
			var muserid = $("#usrid").val();
			var stp = $("#stype").val();
			var myimage = $("<img />", {
				src : "assets/files/"+stp+"/R-"+muserid+"/"+j.name,
				id : 'mimg-'+j.id,
				alt : j.title
			});
			var cap = $("<p />", {
				class : "t_class",
				id : "mtitle-"+j.id,
				html : j.title
			});	
			var buts = $("<a />", {
				class : "btn btn-primary",
				id : "edit-"+j.id,
				role : "button",
				href : "editText.php?imageid="+j.id,
				text : "Edit Title",
				name : j.id
			});
			var delButs = $("<a />", {
				class : "btn btn-primary mybtn",
				id : "delete-"+j.id,
				title : 'Delete Photo',
				role : "button",
				href : "deleteImage.php?imageid="+j.id,
				html : "&times;",
				name : j.id
			});
			var cc = $("<div />", {
				class : "pure-u-1-4 mypure",
				html : myimage
			});
			cc.append ( cap );
			cc.append ( buts );
			cc.append ( delButs );
			$("#disp").append ( cc );
		});
	},
	modalShow : function ( $ev ) {
		var image_link = $ev . attr( 'href' );
		var dat = $ev . attr( 'href' ) . replace(/.+?\?(.*)$/,'$1');
		
		var jj = dat . trim() . split( "=" );
		$( "#myModal" ) . modal ();
		var myimg = $("<img />", {
			'src' : $("#mimg-"+jj[1]) . attr( 'src' ),
			'id' : "m-"+jj[1]
		});
		
		var myp = $("<input />", {
			type : "text",
			class : "myinput",
			id : "input-" + jj[1],
			value : $("#mtitle-" + jj[1]) . html()
		});
		
		var hid = $("<input />", {
			type : 'hidden',
			id : "im",
			value : jj[1]
		});
		
		$( ".modal-body" ) . html ( myimg );
		$( ".modal-body" ) . append( myp );
		$( ".modal-body" ) . append ( hid );
	},
	
	titleChange : function () {
		var input = encodeURIComponent ( $( ".myinput" ).val() );
		var myimgid = encodeURIComponent ( $( "#im" ).val() );
		var sk = $("<img />", {
			src : "assets/img/loader.gif"
		});
		$("#mtitle-"+myimgid).html( sk );
		$( "#myModal" ) . modal ( 'hide' );
		
		var josh = $ . ajax ({
			type : 'get',
			url : 'updateTitle.php',
			data : {
				'imgid' : myimgid,
				'title' : ''+input+''
			},
			dataType : 'json'
		});
		josh . done ( function ( data ) {
			$ . each ( data, function ( i, j ) {
				if ( j.status == "Success" ) {
					$("#salon_theme").trigger('change');
				} else {
					$('#status').html ( '<p>Something wrong !!</p>' );
				}
			});
		});
	},
	
	instImg : function ( data ) {
		var themeid = $("#salon_theme").val();
		var muserid = $("#usrid").val();
		var salontype = $("#saltype").val();
		$("#open-"+themeid).html('');
		
		$("#open-"+themeid) . removeClass ( 'hide' ) . addClass ( 'show' );
		$ . each ( data, function ( i, j ) {
			var muserid = $("#usrid").val();
			var myimage = $("<img />", {
				src : "assets/files/"+salontype+"/R-"+muserid+"/"+j.name,
				id : 'mimg-'+j.id,
				alt : j.title
			});
			var cap = $("<p />", {
				class : "t_class",
				id : "mtitle-"+j.id,
				html : j.title
			});	
			
			var cc = $("<div />", {
				class : "pure-u-1-4 mypure",
				html : myimage
			});
			cc.append ( cap );
			$("#open-"+themeid).append ( cc );
		});
	},
	
	imageDelete : function ( $ev ) {
		var rr = confirm ( 'Do you really want to delete this ?' );
		if ( rr ) {
			var mid = $ev . attr ( 'name' );
			var sk = $("<img />", {
				src : "assets/img/loader.gif"
			});
			$("#mtitle-"+mid).html( sk );
			var themeid = $("#salon_theme").val();
			var kask = $ . ajax ({
				type : 'get',
				url : 'imgDelete.php',
				data : {
					'imid' : mid,
					'themeid' : themeid,
					'salonType' : $('#stype').val()
				},
				dataType : 'json'
			});
			
			kask . done ( function ( data ) {
				$ . each ( data, function ( i, j ) {
					if ( j.status == "Success" ) {
						$("#salon_theme").trigger('change');
					} else {
						$('#status').html ( '<p>Something wrong !!</p>' );
					}
				});
			});
		}
	}
});