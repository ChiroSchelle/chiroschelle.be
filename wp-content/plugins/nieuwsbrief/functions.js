/**
 * @author Ruben Mennes
 */

var i=0;

function addField(){
	var node = document.getElementById("intoForm");
	var todo = [["Titel", "text"], ["Image-url", "text"], ["Text", "textarea"]];
	var elm = document.createElement("div");
	var h4 = document.createElement("h4");
	h4.innerText = "Bericht " + i;
	h4.textContent = "Bericht " + i;
	elm.appendChild(h4);
	var table = document.createElement("table");
	node.appendChild(elm);
	elm.appendChild(table);
	for(j=0; j < todo.length; j++){
		var tr = document.createElement("tr");
		table.appendChild(tr);
		var td = document.createElement("td");
		td.innerText=todo[j][0] + ":";
		td.textContent = todo[j][0] + ":";
		tr.appendChild(td);
		td = document.createElement("td");
		tr.appendChild(td);
		if(todo[j][1] == "textarea"){
			var input = document.createElement("textarea");
			td.appendChild(input);
			input.setAttribute("rows", 6);
			input.setAttribute("cols", 50);
			input.setAttribute("name", todo[j][0] + "_" + i);
		}
		else{
			var input = document.createElement("input");
			td.appendChild(input);
			input.setAttribute("type", todo[j][1]);
			input.setAttribute("name", todo[j][0] + "_" + i);
			input.setAttribute("size", 50);
		}		
	}
	i++;
}

function getPopUp(windowname){
	var features = 'width=602,height=800,toolbar=no,location=no,directories=no,menubar=no,scrollbars=no,copyhistory=no,resizable=no';
	var myWindow = window.open('',windowname, features);
	myWindow.focus();
}

function readyToSend(){
	return confirm("U staat op het punt de nieuwsbrief te versturen. Bent u zeker dat u deze nieuwsbrief wilt versturen?");
}
