<?php

preg_match('%^/([a-z]{2})%', $_SERVER['REQUEST_URI'], $matches);
$langs = array('de', 'en');
$langSpecs = array('de' => 'de-de', 'en' => 'en-us');
$lang = isset($matches[1]) && in_array($matches[1], $langs) ? $matches[1] : 'de';
$htmlLang = $langSpecs[$lang];
$localeLang = substr($htmlLang, 0, 2) . '_' . strtoupper(substr($htmlLang, -2)) . '.utf8';
$switchlang = array_shift(array_filter($langs, function($el) use($lang)
{
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
                $sepPos = strpos($data, '|');
                $startTag = substr($data, 0, $sepPos);
                $endTag = substr($data, $sepPos + 1);
                $str = str_replace("[$id]", $startTag, $str);
                $str = str_replace("[/$id]", $endTag, $str);
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
    <a href="#contact" class="internal"><?php _e('nav.kontakt'); ?></a>
    <a href="#about" class="internal"><?php _e('nav.about'); ?></a>
    <a href="#links" class="internal"><?php _e('nav.links'); ?></a>
    <a href="/<?php echo $switchlang; ?>" class="internal" lang="<?php echo $htmlswitchlang; ?>"
       title="<?php _e('nav.switchlang.titel'); ?>"><em><?php _e('nav.switchlang'); ?></em></a>
</nav>
<div id="main" class="gradient">
    <div id="content">
        <nav class="desktop">
            <a href="/<?php echo $switchlang; ?>" class="internal" lang="<?php echo $htmlswitchlang; ?>"
               title="<?php _e('nav.switchlang.titel'); ?>"><em><?php _e('nav.switchlang'); ?></em></a>
        </nav>
        <aside class="box" id="contact">
            <h2 class="boxtitle gradient"><?php _e('kontakt.headline'); ?></h2>

            <div class="boxbody gradient">
                <p>
                    <strong itemprop="name">Markus Tacker</strong>
                </p>

                <p>
                    <span itemprop="memberOf" itemscope itemtype="http://schema.org/Organization"><a
                        href="http://coderbyheart.de/" itemprop="url" rel="me"> <span itemprop="name">coder::by(<i
                        class="coderbyheart">♥</i>);</span></a><span itemprop="description"
                                                                     class="hidden"><?php _e('organizations.cbh.description'); ?></span></span><br>
                    <span itemprop="jobTitle"><?php _e('kontakt.jobtitle'); ?></span>
                </p>

                <p>
                            <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <span itemprop="streetAddress">Senefelderstr. 63</span><br>
                                <span itemprop="postalCode">63069</span>
                                <span itemprop="addressLocality">Offenbach</span>
                                <span class="hidden"><span itemprop="addressRegion">Hessen</span>,
                                    <span itemprop="addressCountry">Deutschland</span></span></span>
                </p>
                <dl class="icons">
                    <dt><?php _e('kontakt.telefon.label'); ?></dt>
                    <dd itemprop="telephone">
                        <i class="phone"></i><a href="tel:+491796678859">+49 (0) 179 667 88 59</a>
                    </dd>
                    <dt></dt>
                    <dd>
                        <i class="mail"></i><a href="mailto:m@tckr.cc" itemprop="email">m@tckr.cc</a>
                    </dd>
                    <dt><?php _e('kontakt.email.label'); ?></dt>
                    <dd>
                        <i class="link"></i><a href="http://tckr.cc/" itemprop="url" rel="author">tckr.cc</a>
                    </dd>
                    <dt><?php _e('kontakt.email.label'); ?></dt>
                    <dd>
                        <i class="twitter"></i><a href="http://twitter.com/markustacker">@markustacker</a>
                    </dd>
                </dl>
                <h3><?php _e('kontakt.connect'); ?></h3>
                <ul class="icons f f-1-3">
                    <li>
                        <i class="xing"></i><a href="https://www.xing.com/profile/Markus_Tacker" rel="me">XING</a>
                    </li>
                    <li>
                        <i class="linkedin"></i><a href="http://www.linkedin.com/in/markustacker" rel="me">LinkedIn</a>
                    </li>
                    <li>
                        <i class="gplus"></i><a href="http://profiles.google.com/markus.tacker" rel="me">Google+</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
                <hr>
                <p>
                    <small><?php _e('kontakt.vcf', array('link' => '<a href="MarkusTacker.vcf">|</a>')); ?>
                        <br><?php _e('kontakt.qr', array('link' => '<a href="qrcode.html"><i class="qrcode"></i> |</a>')); ?>
                    </small>
                </p>
            </div>
        </aside>
        <article class="box">
            <h2 id="about" class="boxtitle gradient"><?php _e('about.headline'); ?></h2>

            <div class="boxbody gradient">
                <a href="http://www.flickr.com/photos/tacker/6004944000/" rel="me"><img
                    src="http://farm7.staticflickr.com/6147/6004944000_10cf9fb091.jpg" alt="Markus Tacker" class="me"
                    itemprop="image"/></a>

                <p><?php _e('about.intro'); ?></p>

                <p><?php _e('about.cbh', array('coderbyheart' => '<span itemprop="worksFor" itemscope itemtype="http://schema.org/Organization"><a href="http://coderbyheart.de/" itemprop="url" rel="me"> <span itemprop="name">coder::by(<i class="coderbyheart">♥</i>);</span></a><span itemprop="description" class="hidden">' . _g('organizations.cbh.description') . '</span></span>')); ?></p>

                <p><?php _e('about.retext', array('retext' => '<span itemprop="worksFor" itemscope itemtype="http://schema.org/Organization"><i class="retext"></i><a href="http://retext.it/" itemprop="url" rel="me"><span itemprop="name">re:text</span></a><span itemprop="description" class="hidden">' . _g('organizations.retext.description') . '</span></span>')); ?></p>

                <p><?php _e('about.offenraum', array('offenraum' => '<span itemprop="worksFor" itemscope itemtype="http://schema.org/Organization"><i class="offenraum"></i><a href="http://offenraum.de/" itemprop="url" rel="me"><span itemprop="name">offenraum</span></a><span itemprop="description" class="hidden">' . _g('organizations.offenraum.description') . '</span></span>')); ?></p>

                <p><?php _e('about.misc', array('pear' => '<span itemprop="memberOf" itemscope itemtype="http://schema.org/Organization"><i class="pear"></i><a href="http://pear.php.net/" itemprop="url"><span itemprop="name">PEAR</span></a><span itemprop="description" class="hidden">' . _g('organizations.pear.description') . '</span></span>', 'tedx' => '<span itemprop="memberOf" itemscope itemtype="http://schema.org/Organization"><i class="tedx"></i><a href="http://www.tedxrheinmain.de/" itemprop="url"><span itemprop="name">TEDx RheinMain</span></a><span itemprop="description" class="hidden">' . _g('organizations.tedx.description') . '</span></span>')); ?></p>

                <h3 id="links">Weitere Links</h3>
                <dl>
                    <dt>
                        <i class="tackerorg"></i><a href="http://m.tacker.org/blog/" rel="me">Blog</a>
                    </dt>
                    <dd><?php _e('link.blog.about'); ?></dd>
                    <dt>
                        <i class="markusstudiert"></i><a href="http://markusstudiert.de/" rel="me">Markus studiert!</a>
                    </dt>
                    <dd><?php _e('link.markusstudiert.about'); ?></dd>
                    <dt>
                        <i class="flickr"></i><a href="http://www.flickr.com/people/tacker/" rel="me">flickr</a>
                    </dt>
                    <dd><?php _e('link.flickr.about'); ?></dd>
                    <dt>
                        <i class="amazon"></i><a
                        href="https://www.amazon.de/gp/pdp/profile/ATC8QVKE79XBW/?ie=UTF8&amp;site-redirect=de&amp;tag=mtaor-21&amp;linkCode=ur2&amp;camp=1638&amp;creative=19454"><?php _e('link.amazon.title'); ?></a>
                    </dt>
                    <dd><?php _e('link.amazon.about'); ?></dd>
                </dl>
                <p><?php _e('link.profiles'); ?></p>
                <ul class="icons f f-1-4">
                    <li>
                        <i class="github"></i><a href="https://github.com/tacker" rel="me"
                                                 title="tacker@GitHub">GitHub</a>
                    </li>
                    <li>
                        <i class="ted"></i><a href="http://www.ted.com/profiles/1205018" rel="me"
                                              title="TED-Profil">TED</a>
                    </li>
                    <li>
                        <i class="pear"></i><a href="http://pear.php.net/user/tacker" rel="me"
                                               title="tacker@PEAR">PEAR</a>
                    </li>
                    <li>
                        <i class="foursquare"></i><a href="https://de.foursquare.com/markustacker" rel="me"
                                                     title="markustacker@foursquare">foursquare</a>
                    </li>
                    <li>
                        <i class="delicious"></i><a href="http://delicious.com/tacker" rel="me"
                                                    title="tacker@delicious">Delicious</a>
                    </li>
                    <li>
                        <i class="lastfm"></i><a href="http://www.lastfm.de/user/m.tacker/" rel="me"
                                                 title="m.tacker@lastfm">lastFM</a>
                    </li>
                    <li>
                        <i class="qype"></i><a href="http://www.qype.com/people/tacker" rel="me" title="tacker@qype">Qype</a>
                    </li>
                    <li>
                        <i class="youtube"></i><a href="http://www.youtube.com/user/markustacker" rel="me"
                                                  title="markustacker@youtube">YouTube</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </article>
        <div class="clearfix"></div>
    </div>
</div>
<footer>
    <p><?php _e('footer', array('nounproject' => '<a href="http://www.thenounproject.com">The Noun Project</a>', 'markustacker' => '<a href="http://tckr.cc/" rel="author">Markus Tacker</a>', 'github' => '<a href="https://github.com/tacker/tckr.cc">|</a>')); ?></p>
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
</body>
</html>
