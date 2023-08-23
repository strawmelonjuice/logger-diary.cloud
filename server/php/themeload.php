<?php
use Symfony\Component\Yaml\Yaml;
$fontscale = 10.1;
if ($prod) {
  $basecss = "https://cdn.jsdelivr.net/gh/strawmelonjuice/Logger-Diary.Online@{$last_commit_ID}/public/css";
  $cssext = ".min.css";
} else {
  $basecss = "/?getcss=";
  $cssext = ".css";
}
$themeinfo = Yaml::parseFile(__DIR__ . '/../config/themes.yaml'); {
    if ($theme == 'framework') {
        echo "<link rel=\"stylesheet\" href=\"". $basecss . "/themes/mod-framework/base" . $cssext . "\" content-type=\"text/css\" charset=\"utf-8\" />";
        require_once(__DIR__ . '/AccountInteractions.php');
        $chotheme = AccountInteraction($_SESSION['UID'], "Get", "settings", "frameworkmod_theme", "");
    } else {
        $chotheme = $theme;
    }
}
foreach ($themeinfo as $style) {
    if ($style['internal'] == $chotheme) {
        // Match found!
        if ($style['themetype'] == 'auto') {
            echo <<<EndOfThisCode

            <link  media="(prefers-color-scheme: light)" rel="stylesheet" href="{$basecss}/themes/{$style['css-light']}{$cssext}" content-type="text/css" charset="utf-8" />
            <link media="(prefers-color-scheme: dark)" rel="stylesheet" href="{$basecss}/themes/{$style['css-dark']}{$cssext}" content-type="text/css" charset="utf-8" />

            EndOfThisCode;
        } else {
            echo '<link rel="stylesheet" href="' . $basecss . '/themes/' . $style['css'] . $cssext . '" content-type="text/css" charset="utf-8" />';
        }
        switch ($style['themetype']) {
            case 'dark':
                $svgfilter = "invert(90%) sepia(19%) saturate(303%) hue-rotate(284deg) brightness(110%) contrast(101%)";
                break;
            
            case 'light':
                $svgfilter = "brightness(0) saturate(100%)";
                break;
        }
        echo <<<SetScriptEnd
            <style>
                :root {
                    --theme-accent-color: #{$style['color']};
                }
                .svgrecolor {
                    filter: {$svgfilter};
                }
            </style>
            <script>
                const LDtheme = "{$style['internal']}";
                const LDthemetype = "{$style['themetype']}";
                const ScaleFontsTo = {$fontscale};
            </script>

        SetScriptEnd;
    }
}
?>