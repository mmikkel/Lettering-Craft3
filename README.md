# Lettering plugin for Craft CMS 3.x

Like Lettering.js, but in Twig

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require mmikkel/lettering

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Lettering.

## Lettering Overview

_Lettering_ is a port of [Lettering.js](http://letteringjs.com/), for Craft CMS.    

Looking for the Craft 2 version? [It's right here!](https://github.com/sjelfull/Craft-Lettering)

## Using Lettering

### Split on characters
```kinja
{% set text %}
    <p>Foo bar</p>
{% endset %}

{{ text|lettering }}
```

Output:  
```html
<p aria-label="Foo bar">
    <span class="char1" aria-hidden="true">F</span>
    <span class="char2" aria-hidden="true">o</span>
    <span class="char3" aria-hidden="true">o</span>
    <span class="char4" aria-hidden="true"> </span>
    <span class="char5" aria-hidden="true">b</span>
    <span class="char6" aria-hidden="true">a</span>
    <span class="char7" aria-hidden="true">r</span>
</p>
```

### Split on words

```kinja
{% set text %}
    <p>Foo bar baz</p>
{% endset %}
{{ text|lettering('words') }}  
```

Output:  
```html
<p aria-label="Foo bar">
    <span class="word1" aria-hidden="true">Foo</span>
    <span class="word2" aria-hidden="true">bar</span>
    <span class="word3" aria-hidden="true">baz</span>
</p>
```

### Split on lines

```kinja
{% set text %}
    <p>Foo
        bar baz</p>
{% endset %}
{{ text|lettering('lines') }}  
```

Output:  
```html
<p aria-label="Foo bar baz">
    <span class="line1" aria-hidden="true">Foo bar</span>
    <span class="line2" aria-hidden="true">baz</span>
</p>
```

### Tag pair usage

```kinja
{% filter lettering('words') %}  
    <h1>{{ entry.title }}</h1>  
{% endfilter %}
```  

### Extract aria label and chars/words/lines

```kinja
{% set lettering = craft.lettering.chars('Sanctimonious Variable Lettering') %}  

<h1 {{ lettering.ariaLabel }}>{{ lettering.chars }}</h1>
```    

## Disclaimer

This plugin is provided free of charge and you can do whatever you want with it. Lettering is unlikely to mess up your stuff, but just to be clear: the author is not responsible for data loss or any other problems resulting from the use of this plugin.

Please report any bugs, feature requests or other issues [here](https://github.com/mmikkel/Lettering-Craft3/issues). Note that this is a hobby project and no promises are made regarding response time, feature implementations or bug fixes.

**Pull requests are extremely welcome**

Brought to you by [Fred Carlsen](http://sjelfull.no) + [Mats Mikkel Rummelhoff](https://vaersaagod.no)
