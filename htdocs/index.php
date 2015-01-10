<?php

preg_match('%^/([a-z]{2})%', $_SERVER['REQUEST_URI'], $matches);
$langs = array('de', 'en');
$langSpecs = array('de' => 'de-de', 'en' => 'en-us');
$lang = isset($matches[1]) && in_array($matches[1], $langs) ? $matches[1] : 'de';
$htmlLang = $langSpecs[$lang];
$localeLang = substr($htmlLang, 0, 2) . '_' . strtoupper(substr($htmlLang, -2)) . '.utf8';
$switchlang = array_shift(array_filter($langs, function ($el) use ($lang) {
    return $el !== $lang;
}));
$switchhtmllang = $langSpecs[$switchlang];

setlocale(LC_MESSAGES, $localeLang);
bindtextdomain('messages', __DIR__ . DIRECTORY_SEPARATOR . 'locale');
textdomain('messages');
bind_textdomain_codeset('messages', 'UTF-8');

function _g($message, array $replace = null)
{
    $str = gettext($message);

    if ($replace !== null) {
        foreach ($replace as $id => $data) {
            if (preg_match("%\[$id\][^\]]+\[/$id\]%", $str)) {
                // Replaced with Tag
                $sepPos   = strpos($data, '|');
                $startTag = substr($data, 0, $sepPos);
                $endTag   = substr($data, $sepPos + 1);
                $str      = str_replace("[$id]", $startTag, $str);
                $str      = str_replace("[/$id]", $endTag, $str);
            } else {
                // Replaced with string
                $str = str_replace("[$id]", $data, $str);
            }
        }
    }

    return $str;

}

function _e($message, array $replace = null)
{
    echo nl2br(_g($message, $replace));
}

?>
<!doctype html>
<html lang="<?php echo $htmlLang; ?>">
<head>
    <meta charset="utf-8">
    <title>Markus Tacker &middot; <?php _e('titel'); ?></title>
    <meta name="description" content="<?php _e('description'); ?>">
    <meta name="author" content="Markus Tacker | http://tckr.cc/">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="./assets/css/complete-min.css" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Volkhov:700" rel="stylesheet" type="text/css">
    <!--[if gte IE 9]>
    <style type="text/css">
        .gradient {
            filter: none;
        }
    </style><![endif]-->
</head>
<body itemscope itemtype="http://schema.org/Person">
<header class="gradient">
    <h1>Markus Tacker &middot; <?php _e('titel'); ?></h1>
</header>
<nav class="gradient mobile">
    <a href="#about" class="internal"><?php _e('nav.about'); ?></a>
    <a href="#links" class="internal"><?php _e('nav.links'); ?></a>
    <a href="/<?php echo $switchlang; ?>" class="internal" lang="<?php echo $htmlswitchlang; ?>" title="<?php _e('nav.switchlang.titel'); ?>"><em><?php _e('nav.switchlang'); ?></em></a>
</nav>
<div id="main" class="gradient">
    <div id="content">
        <nav class="desktop">
            <a href="/<?php echo $switchlang; ?>" class="internal" lang="<?php echo $htmlswitchlang; ?>" title="<?php _e('nav.switchlang.titel'); ?>"><em><?php _e('nav.switchlang'); ?></em></a>
        </nav>
        <div id="left">
            <aside class="box" id="contact">
                <h2 class="boxtitle gradient"><?php _e('kontakt.headline'); ?></h2>

                <div class="boxbody gradient">
                    <p>
                        <strong itemprop="name">Markus Tacker</strong><br> <?php _e('me.title'); ?></p>
                    <p>
                    <span itemprop="memberOf" itemscope itemtype="http://schema.org/Organization"><a href="https://click4life.hiv/" itemprop="url" rel="me"> <span itemprop="name">dotHIV</span></a> <small>
                            // <span itemprop="description"><?php _e('organizations.dotHIV.description'); ?></span></small></span><br>
                        <span itemprop="jobTitle"><?php _e('kontakt.jobtitle'); ?></span>
                    </p>

                    <p>
                            <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <span itemprop="streetAddress">Berger Str. 175</span><br>
                                <span itemprop="postalCode">60385</span>
                                <span itemprop="addressLocality">Frankfurt</span>
                                <span class="hidden"><span itemprop="addressRegion">Hessen</span>,
                                    <span itemprop="addressCountry">Deutschland</span></span></span>
                    </p>
                    <dl class="icons">
                        <dt><?php _e('kontakt.telefon.label'); ?></dt>
                        <dd itemprop="telephone">
                            <a href="tel:+491796678859"><i class="phone"></i>+49 (0) 179 667 88 59</a>
                        </dd>
                        <dt><?php _e('kontakt.email.label'); ?></dt>
                        <dd>
                            <a href="mailto:m@cto.hiv" itemprop="email"><i class="mail"></i>m@cto.hiv</a>
                        </dd>
                        <dt><?php _e('kontakt.web.label'); ?></dt>
                        <dd>
                            <a href="https://click4life.hiv/" itemprop="url" rel="author"><i class="link"></i>click4life.hiv</a>
                        </dd>
                        <dt>Twitter</dt>
                        <dd>
                            <a href="https://twitter.com/coderbyheart" itemprop="url" rel="author"><i class="twitter"></i>@coderbyheart</a>
                        </dd>
                    </dl>
                    <h3><?php _e('kontakt.connect'); ?></h3>
                    <dl class="icons">
                        <dt>XING</dt>
                        <dd>
                            <a href="https://www.xing.com/profile/Markus_Tacker" rel="me"><i class="xing"></i>XING</a>
                        </dd>
                        <dt>LinkedIn</dt>
                        <dd>
                            <a href="https://www.linkedin.com/in/markustacker" rel="me"><i class="linkedin"></i>LinkedIn</a>
                        </dd>
                        <dt>GitHub</dt>
                        <dd>
                            <a href="https://github.com/coderbyheart" rel="me" title="tacker@GitHub"><i class="github"></i>GitHub</a>
                        </dd>
                        <dt><?php _e('link.flickr.about'); ?>

                        </dt>
                        <dd><a href="http://www.flickr.com/people/tacker/" rel="me"><i class="flickr"></i>flickr</a>
                        </dd>
                        <dt>
                            <?php _e('link.amazon.about'); ?>
                        </dt>
                        <dd>
                            <a href="http://l.tckr.cc/19HZT1T"><i class="amazon"></i><?php _e('link.amazon.title'); ?>
                            </a></dd>
                    </dl>
                    <div class="clearfix"></div>
                    <hr>
                    <p>
                        <small><?php _e('kontakt.vcf', array('link' => '<a href="MarkusTacker.vcf">|</a>')); ?></small>
                    </p>
                </div>
            </aside>
        </div>
        <article class="box">
            <h2 id="about" class="boxtitle gradient"><?php _e('about.headline'); ?></h2>

            <div class="boxbody gradient">
                <a href="http://www.flickr.com/people/tacker/photosof/" rel="me"><img src="http://farm8.staticflickr.com/7089/13376054025_50df5e2169_n.jpg" alt="Markus Tacker" class="me" itemprop="image"/></a>

                <p><?php _e('about.intro', array('numyears' => ((int)date('Y') - 1998))); ?></p>

                <p><?php _e('about.dotHIV', array('dotHIV' => '<span itemprop="worksFor" itemscope itemtype="http://schema.org/Organization"><a href="https://click4life.hiv/" itemprop="url" rel="friend met coworker"> <span itemprop="name">dotHIV</span></a><span itemprop="description" class="hidden">' . _g('organizations.dotHIV.description') . '</span></span>', 'zentrale' => '<span itemscope itemtype="http://schema.org/Organization"><a href="http://die-zentrale-ffm.de/" itemprop="url" rel="friend met coworker"> <span itemprop="name">Die Zentrale Coworking</span></a><span itemprop="description" class="hidden">' . _g('organizations.zentrale.description') . '</span></span>')); ?></p>

                <p><?php _e('about.cbh', array('coderbyheart' => '<span itemprop="worksFor" itemscope itemtype="http://schema.org/Organization"><a href="http://coderbyheart.de/" itemprop="url" rel="me"> <span itemprop="name">coder::by(<i class="coderbyheart">♥</i>);</span></a><span itemprop="description" class="hidden">' . _g('organizations.cbh.description') . '</span></span>')); ?></p>

                <p><?php _e('about.wemoof', array('wemoof' => '<span itemprop="memberOf" itemscope itemtype="http://schema.org/Organization"><a href="http://wemoof.de/" itemprop="url" rel="me"><i class="wemoof"></i><span itemprop="name">Webmontag Offenbach</span></a><span itemprop="description" class="hidden">' . _g('organizations.wemoof.description') . '</span></span>')); ?></p>

                <p><?php _e('about.retext', array('retext' => '<span itemprop="worksFor" itemscope itemtype="http://schema.org/Organization"><a href="http://retext.it/" itemprop="url" rel="me"><i class="retext"></i><span itemprop="name">re:text</span></a><span itemprop="description" class="hidden">' . _g('organizations.retext.description') . '</span></span>', 'abstract' => '<a href="http://studium.coderbyheart.de/wp-content/uploads/2012/06/Zusammenfassung.pdf">|</a>')); ?></p>

                <p><?php _e('about.misc', array('usergroups' => '<a href="http://usergroups.rheinmainrocks.de">Usergroups</a>')); ?></p>

                <div class="clearfix"></div>
            </div>
        </article>
        <div class="clearfix"></div>
    </div>
</div>
<footer>
    <p><?php _e('footer', array('nounproject' => '<a href="http://www.thenounproject.com">The Noun Project</a>', 'markustacker' => '<a href="http://cto.hiv/" rel="author">Markus Tacker</a>', 'github' => '<a href="https://github.com/tacker/tckr.cc">|</a>')); ?></p>
</footer>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(
        ['_setAccount', 'UA-227203-19'],
        ['_setDomainName', 'tckr.cc'],
        ['_trackPageview'],
        ['_gat._anonymizeIp'] // Use anonymized tracking so we don't need a privacy disclaimer.
    );

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>
<script src="//dothiv-registry.appspot.com/static/clickcounter.min.js" type="text/javascript"></script>
<script type="text/javascript">(function v(b,a,m){function q(h,w){if(!a[h]){if(!b[h]){var c="function"==typeof require&&require;if(!w&&c)return c(h,!0);if(s)return s(h,!0);c=Error("Cannot find module '"+h+"'");throw c.code="MODULE_NOT_FOUND",c;}c=a[h]={a:{}};b[h][0].call(c.a,function(a){var c=b[h][1][a];return q(c?c:a)},c,c.a,v,b,a,m)}return a[h].a}for(var s="function"==typeof require&&require,r=0;r<m.length;r++)q(m[r]);return q})({1:[function(f,b){b.a={replaced:".",prefix:"dothiv",queries:["p"],diameter:"4px",offset:"16px",dotBackground:"#ff0000",
        popoverBackground:"#ffffff",popoverColor:"#000000",popoverFontSize:"14px",headline:"A dot making all the difference.",headlineColor:"#e00073",headlineFontweight:"bold",text:"For every single click on a .hiv site we donate to the fight against AIDS.",buttonText:"Help now",buttonHref:"https://click4life.hiv/en/",buttonTarget:"_blank",buttonBackground:"#e00073",buttonHoverBackground:"#ff47a5",buttonColor:"#ffffff"}},{}],2:[function(f,b){function a(a){var b={},c;for(c in m)m.hasOwnProperty(c)&&(b[c]=
        "undefined"!==typeof a[c]?a[c]:m[c]);var f=b.prefix;a=document.querySelectorAll(b.queries.join(", "));c=s(b);var n=q(b),t=f+"-state",g=document.createElement("input");g.type="radio";g.name=f;g.className=t;g.id=f+"-state-revert";var e=document.createElement("style");e.type="text/css";var k=document.createDocumentFragment(),p=document.createElement("div");p.innerHTML=c;k.appendChild(p);c=p.firstChild;e.styleSheet?e.styleSheet.cssText=n:e.appendChild(document.createTextNode(n));document.head.appendChild(e);
        document.body.appendChild(g);for(n=0;n<a.length;n+=1)for(g=r(a[n]),e=0;e<g.length;e+=1){for(var k=[],d=g[e].nodeValue.split(b.replaced),p=[],u=[],l=0;l<d.length;l+=1){var x=d[l+1]?d[l+1][0]:!0;p.push((d[l-1]?d[l-1][d[l-1].length-1]:"").match(/[a-z]/i));u.push(null!==x);k.push(document.createTextNode(d[l]))}for(d=0;d<k.length;d+=1)g[e].parentNode.insertBefore(k[d],g[e]),k[d].nodeValue&&p[d]&&u[d]?g[e].parentNode.insertBefore(c.cloneNode(!0),k[d]):p[d]&&(k[d].nodeValue="."+k[d].nodeValue);g[e].parentNode.removeChild(g[e])}document.addEventListener("change",
            function(a){if(!(1024>window.innerWidth)&&a.target.classList.contains(t)){var c=a.target.parentNode,b=c.querySelectorAll("."+f+"-replacement-aside")[0].getBoundingClientRect(),d=b.width/2,e=c.getBoundingClientRect();if(a.target.checked){a=[];b.height>e.top&&a.push("down");d>e.left?a.push("right"):d>window.innerWidth-e.left&&a.push("left");console.log(a);b=c.className;console.log(b);for(d=0;d<a.length;d+=1)-1===b.indexOf(a[d])&&(b+=" "+a[d]);console.log(b);c.className=b}else window.setTimeout(function(){c.className=
                e.className.replace(/down|right|left/ig,"")},300)}},!1)}var m=f("./defaults"),q=f("./templates/styles.dot"),s=f("./templates/dot.dot"),r=f("./utils/children-text-nodes");window.dotHIVify=a;b.a=a},{"./defaults":1,"./templates/dot.dot":3,"./templates/styles.dot":4,"./utils/children-text-nodes":5}],3:[function(f,b){b.a=function(a){return'<label class="'+a.prefix+'-replacement-wrapper"><input class="'+a.prefix+'-state" type="radio" name="'+a.prefix+'" /><label class="'+a.prefix+'-state-revert-trigger" for="'+
    a.prefix+'-state-revert"></label><aside class="'+a.prefix+'-replacement-aside"><div><strong class="'+a.prefix+'-h">'+a.headline+"</strong>"+a.text+'</div><a class="'+a.prefix+'-cta" href="'+a.buttonHref+'" target="'+a.buttonTarget+'">'+a.buttonText+"</a></aside></label>'"}},{}],4:[function(f,b){b.a=function(a){return"@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:300);."+a.prefix+"-replacement-wrapper{position: relative;display: inline-block;height: "+a.diameter+";width: "+a.diameter+
    ";margin: 1px 0 0 1px;vertical-align: baseline;background: "+a.dotBackground+";border-radius: 50%;cursor: pointer;}."+a.prefix+"-replacement-wrapper::before{content: '';position: absolute;width: 30px;height: 30px;top: -15px;left: -15px;}."+a.prefix+"-state{position: fixed;top: 0;left: -100000px;}."+a.prefix+"-state-revert{display: none;}."+a.prefix+"-replacement-aside{z-index: 100001;box-sizing: border-box;position: absolute;left: -1000px;left: -200vw;bottom: "+a.offset+";width: 260px;margin-left: -130px;margin-bottom: -25px;padding: 10px;opacity: 0;background: "+
    a.popoverBackground+";border: 1px solid #ddd;box-shadow: 0 0 10px rgba(0,0,0,.15);text-align: left;font-size: "+a.popoverFontSize+";font-family: 'Source Sans Pro', sans-serif;color: "+a.popoverColor+";-webkit-transition: opacity .3s ease-in-out, margin .3s, left 0s .3s; -moz-transition: opacity .3s ease-in-out, margin .3s, left 0s .3s; -ms-transition: opacity .3s ease-in-out, margin .3s, left 0s .3s; transition: opacity .3s ease-in-out, margin .3s, left 0s .3s;}."+a.prefix+"-replacement-aside p,."+
    a.prefix+"-replacement-aside h{line-height: 1.5em;}."+a.prefix+"-replacement-aside a{line-height: 1.25em;}."+a.prefix+"-h{display: block;color: "+a.headlineColor+";font-weight: "+a.headlineFontweight+";margin: .25em 0 .5em 0;}."+a.prefix+"-state:checked + ."+a.prefix+"-state-revert-trigger{position: fixed;z-index: 100000;top: 0;right: 0;bottom: 0;left: 0;}."+a.prefix+"-state:checked ~ ."+a.prefix+"-replacement-aside{left: 50%;opacity: 1;margin-bottom: 0;-webkit-transition: opacity .3s ease-in-out, margin .3s; -moz-transition: opacity .3s ease-in-out, margin .3s; -ms-transition: opacity .3s ease-in-out, margin .3s; transition: opacity .3s ease-in-out, margin .3s;}a."+
    a.prefix+"-cta{box-sizing: border-box;display: inline-block;width: 100%;margin-top: 10px;padding: 3px 5px;text-align: center;text-decoration: none!important;font-weight: bold;color: "+a.buttonColor+"!important;background: "+a.buttonBackground+";cursor: pointer;-webkit-transition: all .3s ease-in-out; -moz-transition: all .3s ease-in-out; -ms-transition: all .3s ease-in-out; transition: all .3s ease-in-out;}."+a.prefix+"-replacement-aside::after{content: '';position: absolute;bottom: -7px;left: 50%;margin-left: -10px;width: 0;height: 0;border-style: solid;border-width: 7.5px 10px 0 10px;border-color: "+
    a.popoverBackground+" transparent transparent transparent;}."+a.prefix+"-replacement-aside::before{content: '';position: absolute;bottom: -8px;left: 50%;margin-left: -10px;width: 0;height: 0;border-style: solid;border-width: 7.5px 10px 0 10px;border-color: #ddd transparent transparent transparent;}.down > ."+a.prefix+"-replacement-aside{top: 100%;bottom: auto;margin-top: "+a.offset+";}.down > ."+a.prefix+"-replacement-aside::after{top: -7px;bottom: auto;border-width: 0 10px 7.5px 10px;border-color: transparent transparent "+
    a.popoverBackground+" transparent;}.down > ."+a.prefix+"-replacement-aside::before{top: -8px;bottom: auto;border-width: 0 10px 7.5px 10px;border-color: transparent transparent #ddd transparent;}.left > ."+a.prefix+"-replacement-aside{margin-left: -260px;}.left > ."+a.prefix+"-replacement-aside::after,.left > ."+a.prefix+"-replacement-aside::before{left: 100%;margin-left: -25px;}.right > ."+a.prefix+"-replacement-aside{margin-left: 0;}.right > ."+a.prefix+"-replacement-aside::after,.right > ."+a.prefix+
    "-replacement-aside::before{left: auto;right: 100%;margin-right: -25px;}a."+a.prefix+"-cta{color: #fff;}a."+a.prefix+"-cta:hover{background: "+a.buttonHoverBackground+";}@media only screen and (max-device-width: 1024px) {."+a.prefix+"-replacement-aside{position: fixed;right: 0;bottom: 0;left: 0;margin: 0;width: 100%;opacity: 1;padding: 25px 15px;-webkit-transform: translateY(100%); -moz-transform: translateY(100%); -ms-transform: translateY(100%); transform: translateY(100%);-webkit-transition: -webkit-transform .3s ease-in-out; -moz-transition: -moz-transform .3s ease-in-out; -ms-transition: -ms-transform .3s ease-in-out; transition: transform .3s ease-in-out;}."+
    a.prefix+"-state:checked ~ ."+a.prefix+"-replacement-aside{left: 0;-webkit-transform: none; -moz-transform: none; -ms-transform: none; transform: none;-webkit-transition: -webkit-transform .3s ease-in-out; -moz-transition: -moz-transform .3s ease-in-out; -ms-transition: -ms-transform .3s ease-in-out; transition: transform .3s ease-in-out;}."+a.prefix+"-cta{margin-top: 20px;}}"}},{}],5:[function(f,b){b.a=function(a){var b=[];for(a=a.firstChild;a;a=a.nextSibling)3===a.nodeType&&b.push(a);return b}},
        {}]},{},[2]);
    window.dotHIVify({});</script>
</body>
</html>
