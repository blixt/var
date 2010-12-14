<?php
# Using the Wordnik API (http://www.wordnik.com/).
function getWord($type) {
    $apiKey = 'YOUR WORDNIK API KEY HERE';
    $context = stream_context_create(
        array('http' => array('method' => 'GET',
                              'header' => 'api_key:' . $apiKey)));
    $res = json_decode(file_get_contents('http://api.wordnik.com/api/words.json/randomWords?includePartOfSpeech=' . $type . '&minLength=4&limit=1', false, $context));
    return $res[0]->wordstring;
}

# Get an adjective followed by a noun. Treat dashes the same way as spaces.
$words = explode('-', strtolower(str_replace(' ', '-', getWord('adjective') . '-' . getWord('noun'))));
switch (rand(0, 1)) {
case 0:
    # Camel case variable names.
    $var = $words[0];
    for ($i = 1; $i < count($words); $i++) {
        $var .= ucfirst($words[$i]);
    }

    switch (rand(0, 3)) {
    case 0:
        $definition = '<span class="kw">string</span> ' . $var . ' <span class="op">=</span> <span class="str">"Hello World!"</span>;';
        break;
    case 1:
        $definition = '<span class="kw">int</span> ' . $var . ' <span class="op">=</span> <span class="num">1337</span>;';
        break;
    case 2:
        $definition = '<span class="kw">double</span> ' . $var . ' <span class="op">=</span> <span class="num">3.14</span>;';
        break;
    case 3:
        $definition = '<span class="kw">var</span> ' . $var . ' <span class="op">=</span> location.href;';
        break;
    }

    break;
case 1:
    # Python-style variable names.
    $var = implode('_', $words);

    switch (rand(0, 2)) {
    case 0:
        $definition = '<span class="kw">from</span> __future__ <span class="kw">import</span> ' . $var;
        break;
    case 1:
        $definition = $var . ' <span class="op">=</span> <span class="num">1337</span>';
        break;
    case 2:
        $definition = $var . ' <span class="op">=</span> <span class="str">\'Hello World!\'</span>';
        break;
    }

    break;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>What should I call that variable?</title>
<style>
* {
    margin: 0;
    padding: 0;
}

h1 {
    color: #fff;
    font: 30px/1 monospace;
    margin: 50px auto 0;
    text-align: center;
}

h1 span.kw {
    color: #c73;
}

h1 span.num {
    color: #6c99bb;
}

h1 span.op {
    color: #c73;
}

h1 span.str {
    color: #a5c261;
}

html {
    background: #222;
}
</style>
</head>
<body>
<h1><?php echo $definition; ?></h1>
</body>
</html>
