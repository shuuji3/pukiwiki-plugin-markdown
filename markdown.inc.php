<?php

function plugin_markdown_header()
{
    return <<<'EOS'
<script src="https://unpkg.com/markdown-it/dist/markdown-it.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const mdBodies = document.querySelectorAll('.md-body');
    mdBodies.forEach(mdBody => {
      mdBody.innerHTML = window.markdownit().render(mdBody.textContent);
    });
  });
</script>
EOS;
}

function plugin_markdown_convert()
{
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
