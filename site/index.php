<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<title>Otoniel Reyes' Blog</title>
<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$requestedPath = $_SERVER['REQUEST_URI'];
$githubRepo = 'kenliten/otonielreyes.com';
$githubToken = $_ENV['GITHUB_TOKEN'];

// Function to render Markdown content
function renderMarkdown($content)
{
    $parsedown = new Parsedown();
    echo $parsedown->text($content);
}

// Get a random stylesheet from the 'themes' folder
// Fetch available themes list from GitHub
$availableThemesPath = "https://api.github.com/repos/$githubRepo/contents/themes/available";
$availableThemesContent = fetchGitHubContent($availableThemesPath);

if ($availableThemesContent !== false) {
    // Extract available themes from the response
    $availableThemes = [];
    $availableThemeFiles = explode('\n', base64_decode($availableThemesContent['content']));

    foreach($availableThemeFiles as $theme) {
        $availableThemes[] = $theme;
    }

    // Randomly select a theme
    $randomTheme = $availableThemes[array_rand($availableThemes)];

    // Generate the link tag for the selected theme
    echo "<link rel='stylesheet' href='https://raw.githubusercontent.com/$githubRepo/main/themes/$randomTheme'>";
    echo "</head><body>";
}

// Check if the requested route starts with '/blog/'
if (strpos($requestedPath, '/blog/') === 0) {
    $blogEntry = str_replace('/blog/', '', $requestedPath);
    $blogEntryPath = $blogEntry == '' ? "https://api.github.com/repos/$githubRepo/contents/blog/index.md" : "https://api.github.com/repos/$githubRepo/contents/blog/$blogEntry.md";

    // Fetch the requested blog entry content from GitHub
    $blogContent = fetchGitHubContent($blogEntryPath);

    if ($blogContent !== false) {
        echo $blogContent;
        renderMarkdown(base64_decode($blogContent['content']));
    } else {
        // Show the 404.md from the 'pages' folder
        renderMarkdown(base64_decode(fetchGitHubContent("https://api.github.com/repos/$githubRepo/contents/pages/404.md")['content']));
    }
} else {
    // Check if the requested route is like /page-slug-here
    $requestedSlug = substr($requestedPath, 1); // Remove the leading '/'
    $pagePath = $requestedSlug == '' ? "https://api.github.com/repos/$githubRepo/contents/pages/index.md" :  "https://api.github.com/repos/$githubRepo/contents/pages/$requestedSlug.md";

    // Fetch the requested page content from GitHub
    $pageContent = fetchGitHubContent($pagePath);

    if ($pageContent !== false) {
        renderMarkdown(base64_decode($pageContent['content']));
    } else {
        // Show the 404.md from the 'pages' folder
        renderMarkdown(base64_decode(fetchGitHubContent("https://api.github.com/repos/$githubRepo/contents/pages/404.md")['content']));
    }
}

// Function to fetch content from GitHub
function fetchGitHubContent($url)
{
    global $githubToken;
    $options = [
        'http' => [
            'header' => "Authorization: token $githubToken\r\n" . "User-Agent: Otoniel Reyes' Blog"
        ]
    ];
    $context = stream_context_create($options);
    $content = @file_get_contents($url, false, $context);

    return $content ? json_decode($content, true) : false;
}
?>

</body>
</html>