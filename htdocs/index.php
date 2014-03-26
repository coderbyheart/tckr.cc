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
                    <span itemprop="memberOf" itemscope itemtype="http://schema.org/Organization"><a href="http://dotHIV.org/" itemprop="url" rel="me"> <span itemprop="name">dotHIV</span></a> <small>
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
                            <a href="mailto:m@dotHIV.org" itemprop="email"><i class="mail"></i>m@dotHIV.org</a>
                        </dd>
                        <dt><?php _e('kontakt.web.label'); ?></dt>
                        <dd>
                            <a href="http://dotHIV.org/" itemprop="url" rel="author"><i class="link"></i>dotHIV.org</a>
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
                            <a href="https://github.com/tacker" rel="me" title="tacker@GitHub"><i class="github"></i>GitHub</a>
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

                <p><?php _e('about.dotHIV', array('dotHIV' => '<span itemprop="worksFor" itemscope itemtype="http://schema.org/Organization"><a href="http://dotHIV.org/" itemprop="url" rel="me"> <span itemprop="name">dotHIV</span></a><span itemprop="description" class="hidden">' . _g('organizations.dotHIV.description') . '</span></span>')); ?></p>

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
