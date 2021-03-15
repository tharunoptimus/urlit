var qr;
(function() {
        qr = new QRious({
        element: document.getElementById('qr-code'),
        size: 200,
        value: '<?php echo $finalURL; ?>'
    });
})();
function showQR() {
	var x = document.getElementById("qr-code");
	var y = document.getElementById("disable");
	x.style.display = "block";
	y.style.display = "none";
}
function copyFunction() {
	var copyText = document.getElementById("myInput");
	copyText.select();
	copyText.setSelectionRange(0, 99999)
	document.execCommand("copy");
}
function select_text(){
    var urlbox = document.getElementById("myInput");
    if(urlbox)
    {
        urlbox.focus();
        urlbox.select();
    }
    shorturloff();	
}