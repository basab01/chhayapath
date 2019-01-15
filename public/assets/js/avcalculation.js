$(document).ready(function(){

$("#vldisp").hide();
$(".para2").hide();
$(".repeat").hide();

$("#vland").keyup(function() { 
var vl = $("#vland").val();
if(vl == 'Y' || vl == 'y')
{

$("#vldisp").show();

}

else
{
$("#vldisp").hide();

}

 });






$("#nstruct").click(function(){  // on change...
    var stype = $(this).val();    
    if($(this).is(":checked"))
    {
    

	$(".para2").show();

    } 

    else
    {

	$(".para2").hide();

    }

});


$("#nstruct1").click(function(){  // on change...
    var stype1 = $(this).val();    
    if($(this).is(":checked"))
    {

	$(".repeat").show();

    } 

	
   else
    {

	$(".repeat").hide();

    }

});





});



		function addRow(tableID){
			var table=document.getElementById(tableID);
			var rowCount=table.rows.length;
			var row=table.insertRow(rowCount);
			var colCount=table.rows[0].cells.length;
			for(var i=0;i<colCount;i++){
				var newcell=row.insertCell(i);
				newcell.innerHTML=table.rows[0].cells[i].innerHTML;
				switch(newcell.childNodes[0].type){
				case"text":
					newcell.childNodes[0].value="";
					break;
				case"checkbox":
					newcell.childNodes[0].checked=false;
					break;
				case"select-one":
					newcell.childNodes[0].selectedIndex=0;
					break;
				}
			}
		}
		function deleteRow(tableID){
			try{
				var table=document.getElementById(tableID);
				var rowCount=table.rows.length;
				for(var i=0;i<rowCount;i++){
					var row=table.rows[i];
					var chkbox=row.cells[6].childNodes[0];
					if(null!=chkbox&&true==chkbox.checked){
						if(rowCount<=1){
							alert("Cannot delete all the rows.");
							break;
						}
						table.deleteRow(i);
						rowCount--;
						i--;
					}
				}
			}catch(e){
				alert(e);
			}
		}