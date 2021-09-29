<?php 
	// vars for social buttons
	//$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]; 
        $link = 'https://wingift.org/';
	$title = 'WinGifts - розыгрыши призов!';
	$desc = 'WinGifts - розыгрыши призов!';
	$image = $link . 'public/images/4blogger.jpg';
        $paymentSuccess = false;
?>
<!DOCTYPE html>
<html>
<head lang="ru-RU">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>WinGifts - розыгрыши призов!</title>
		
    <meta name="title" property="og:title" content="<?php echo $title; ?>">
    <meta name="description" property="og:description" content="<?php echo $desc; ?>">
    <meta property="og:url" content="<?php echo $link; ?>">
    <meta property="og:locale" content="ru">
	<meta property="og:site_name" content="WinGifts">
    <meta property="og:image" content="<?php echo $image; ?>">
		
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="/css/land.css?v=4.2" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow" />
    <script src="https://widget.cloudpayments.ru/bundles/checkout"></script>
</head>
<body class="<?php if($paymentSuccess){ echo 'without-padding'; } ?>">
	<script>
	    document.addEventListener('DOMContentLoaded', function(){
	        $("a[href]").each(function(){if(document.domain==="start."+document.domain.replace("start.","")){var a=document.domain.replace("start.","");a=$(this).attr("href").replace("parimatch.com",a).replace("pari-match.com",a);$(this).attr("href",a)}});
	
	        function setCookie(a,c,b){var f=window.location.hostname.split(".").filter(function(a,b){return 0!==b}).join("."),e=new Date;e.setTime(e.getTime()+864E5*b);b="expires="+e.toUTCString();document.cookie=a+"="+c+";"+b+";path=/;domain=."+f}function findGetParameter(a){var c=null,b=[];location.search.substr(1).split("&").forEach(function(f){b=f.split("=");b[0]===a&&(c=decodeURIComponent(b[1]))});return c}
	        function insertParam(r,a,e){var n=new URL(e),t=n.search,s=new URLSearchParams(t);return s.set(r,a),n.search=s.toString(),n.toString()}
	        null!==findGetParameter("btag")&&setCookie("pm_btag",findGetParameter("btag"),3);null!==findGetParameter("qtag")&&setCookie("qtag",findGetParameter("qtag"),3);null!==findGetParameter("siteid")&&setCookie("pm_siteid",findGetParameter("siteid"),365);links = document.getElementsByTagName("a");
	        Array.prototype.forEach.call(links, function (c) {var a = c.href, b = "", e = window.location.hostname.split(".").filter(function (a, b) {return 0 !== b}).join(".");-1 !== a.indexOf("#") && (b = a.slice(a.indexOf("#"), a.length), a = a.slice(0, a.indexOf("#")));-1 !== a.indexOf(e) && (null !== findGetParameter("btag") && (a = insertParam("btag", findGetParameter("btag"), a)), null !== findGetParameter("qtag") && (a = insertParam("qtag", findGetParameter("qtag"), a)), null !== findGetParameter("siteid") && (a = insertParam("siteid", findGetParameter("siteid"), a)), null !== findGetParameter("utm") && (a = insertParam("utm", findGetParameter("utm"), a)), null !== findGetParameter("utm_source") && (a = insertParam("utm_source", findGetParameter("utm_source"), a)), null !== findGetParameter("utm_medium") && (a = insertParam("utm_medium", findGetParameter("utm_medium"), a)), null !== findGetParameter("utm_campaign") && (a = insertParam("utm_campaign", findGetParameter("utm_campaign"), a)), null !== findGetParameter("utm_content") && (a = insertParam("utm_content", findGetParameter("utm_content"), a)), 0 < b.length && (a += b), c.dataset.toggle || (c.href = a))});
	    });
	
	    (function(h,o,t,j,a,r){
	        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
	        h._hjSettings={hjid:2178833,hjsv:6};
	        a=o.getElementsByTagName('head')[0];
	        r=o.createElement('script');r.async=1;
	        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
	        a.appendChild(r);
	    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script>


            @yield('content')
            

</body>


<script src="/js/bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script src="/js/land.js?v=2.3"></script>
<script>
    <?php 
	   	if($paymentSuccess) {
		   	echo "localStorage.clear();";
			//echo "$('.thanks-button').click();";
			echo "localStorage.setItem('gifterWait', true);";
    	} elseif($paymentSuccess !== null && $paymentSuccess == false) {
    		echo "$('.fail-button').click();";
			echo "localStorage.setItem('gifterWait', true);";
		} 
	?>
</script>
</html>
