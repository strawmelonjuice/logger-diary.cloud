<?php
if (isset($_GET["NoLang"])) {
	if ($_GET["NoLang"] == true) {
		$_SESSION["NoLang"] = true;
		unset($_SESSION['LANG']);
	} else {
		$_SESSION["NoLang"] = false;
		unset($_SESSION['LANG']);
	}
}
if ($_SESSION["NewLogin"] = true) {
	unset($_SESSION['LANG']);
}

    require_once(__DIR__ . "/../../vendor/autoload.php");
    use Symfony\Component\Yaml\Yaml;
	// Languages we support
    $available_languages = array();
    foreach((glob(__DIR__ . '/../config/lang/*.yaml')) as $file) {
    $file = pathinfo($file);
    $available_languages[] = $file['filename'];
    }
	$default_language = "en"; // a default language to fall back to in case there's no match

	function prefered_language($available_languages, $http_accept_language) {
		global $default_language;
		$available_languages = array_flip($available_languages);

		$langs = array();
		preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
		foreach($matches as $match) {

			list($a, $b) = explode('-', $match[1]) + array('', '');
			$value = isset($match[2]) ? (float) $match[2] : 1.0;

			if(isset($available_languages[$match[1]])) {
				$langs[$match[1]] = $value;
				continue;
			}

			if(isset($available_languages[$a])) {
				$langs[$a] = $value - 0.1;
			}

		}
		if($langs) {
			arsort($langs);
			return key($langs); // We don't need the whole array of choices since we have a match
		} else {
			return $default_language;
		}
	}
if (!isset($_SESSION['LANG'])) {
		if ((isset($_GET["NoLang"])) and ($_SESSION["NoLang"])) {
			$_SESSION['LANG'] = Yaml::parseFile(__DIR__ . '/../config/lang/en.yaml');
			echo "NoLang mode is on.";
		} else {
			$UserLang = prefered_language($available_languages, strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]));
			$_SESSION['LANG'] = Yaml::parseFile(__DIR__ . '/../config/lang/en.yaml');
			$_SESSION['LANG'] = Yaml::parseFile(__DIR__ . '/../config/lang/'. $UserLang .'.yaml');
		}
	}
    // echo $_SESSION['LANG'][2];
function LoadLang($lang) {
		if ((isset($_GET["NoLang"])) and ($_SESSION["NoLang"])) {
			$_SESSION['LANG'] = Yaml::parseFile(__DIR__ . '/../config/lang/en.yaml');
			echo "NoLang mode is on.";
		} else {
			$_SESSION['LANG'] = Yaml::parseFile(__DIR__ . '/../config/lang/en.yaml');
			$_SESSION['LANG'] = Yaml::parseFile(__DIR__ . '/../config/lang/'. $lang .'.yaml');
	}
}
$LanguageActionsAvailable = 1;