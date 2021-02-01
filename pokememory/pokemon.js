var karten = ["pokememory/1.jpg", "pokememory/2.jpg", "pokememory/3.jpg", "pokememory/4.jpg", 
	      "pokememory/5.jpg", "pokememory/6.jpg", "pokememory/7.jpg", "pokememory/8.jpg", 
	      "pokememory/1.jpg", "pokememory/2.jpg", "pokememory/3.jpg", "pokememory/4.jpg", 
	      "pokememory/5.jpg", "pokememory/6.jpg", "pokememory/7.jpg", "pokememory/8.jpg"];
karten.sort(function(a, b){return 0.5 - Math.random()});
var m =0;
var start = true;
var starttime;
var n;
function user() {
  var txt;
  txt = "Willkommen <?php echo $_SESSION['logusername'] ?>";
  document.getElementById("user").innerHTML = txt;
};

function kartenwechseln(id) {
	if(start){
	var d = new Date();
  n = d.getTime();
	start = false;
	};
karte = document.getElementById(id); 
	if (karte.dataset.status != "b"){
	m+=1;
	};
	if (pr(2)){
	timetochange(id);
	};

 switch(karte.dataset.status) {
     case "bg":
         karte.src=karten[id-1];
         karte.dataset.status="pic";
         break;
		case "pic":
         karte.src="pokememory/bg1.jpg";
         karte.dataset.status="bg";
         break;
   }
  if (checkend ()){
	var d1 = new Date();
  var n1 = d1.getTime();
	var endtime = (n1-n)/1000;
	alert("Gratulation! \nSchritte " + m + "\nZeit " + endtime.toFixed(2) + " Sekunden");
	};
};

function pr(n){
var i;
var k = 0;
for (i=1; i<17; i++){
	var a = document.getElementById(i);
	if (a.dataset.status == "pic"){
		k++;
	};
};
if ( k == n){
	return true;
} else {
	return false;
};
};

function timetochange(id) {
var id1 = getid1();
var id2 = getid2(id1);;
var i;

var a = document.getElementById(id1)
var b = document.getElementById(id2);
			if (a.src == b.src) {
				a.src = b.src = "pokememory/bg2.jpg";
				a.dataset.status = b.dataset.status = "b";
			} else {
			if (a.id != id & b.id != id){
				a.src = b.src = "pokememory/bg1.jpg";
				a.dataset.status = b.dataset.status = "bg";
				};
			};
}; 
function getid1 (){
	for (i=1; i<17; i++){
		var c = document.getElementById(i);
		if (c.dataset.status == "pic"){
		return i;
		};
	};
};

function getid2 (id1){
	for (i=1; i<17; i++){
		var c = document.getElementById(i);
		if (c.dataset.status == "pic" & i != id1){
		return i;
		};
	};
};

function checkend (){
var b = 0;
var ik = 0;
var j;
for (j=1; j<17; j++){
		var c = document.getElementById(j);
		if (c.dataset.status == "pic"){
		ik++;
		};
		if (c.dataset.status == "b"){
		b++;
		};
	};
	if (b == 14 & ik == 2){
	return true;
	} else {
	return false; 
	};
};