<?php

function plugin_markdown_header() {
    return <<<'EOS'
<script src="https://unpkg.com/markdown-it/dist/markdown-it.min.js"></script>
<script src="https://unpkg.com/highlightjs"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Load GitHub style for <code> tag
    const style = document.createElement('link');
    style.href = 'https://unpkg.com/highlightjs/styles/github-gist.css';
    style.type = 'text/css';
    style.rel = 'stylesheet';
    document.head.appendChild(style);

    const mdBodies = document.querySelectorAll('.md-body');
    mdBodies.forEach(mdBody => {
      mdBody.innerHTML = window.markdownit({
        linkify: true,
        langPrefix:   'language-',
        highlight: function (str, lang) {
          if (lang && hljs.getLanguage(lang)) {
            try {
              return '<pre class="hljs"><code>' +
                hljs.highlight(lang, str, true).value +
               '</code></pre>';
            } catch (__) {}
          }
          return '<pre class="hljs"><code>' + window.markdownit().utils.escapeHtml(str) + '</code></pre>';
        },
      }).render(mdBody.textContent);
    });
  });
</script>
EOS;
}

function plugin_markdown_convert() {
    $header = "";
    if (!defined("PLUGIN_MARKDOWN_LOADED")) {
        define("PLUGIN_MARKDOWN_LOADED", "LOADED");
        $header = plugin_markdown_header();
    }

    $args = func_get_args();
    $body = array_pop($args);

    return $header . "<div class=\"md-body\">" . $body . "</div>";
}

?>
