<?php
require 'vendor/autoload.php';

use Parsedown;

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
$themesFolder = 'themes';
$stylesheets = glob($themesFolder . '/*.css');
$randomStylesheet = $stylesheets[array_rand($stylesheets)];

// Output the randomly selected stylesheet
echo "<link rel='stylesheet' href='$randomStylesheet'>";

// Check if the requested route starts with '/blog/'
if (strpos($requestedPath, '/blog/') === 0) {
    $blogEntry = str_replace('/blog/', '', $requestedPath);
    $blogEntryPath = "https://api.github.com/repos/$githubRepo/contents/blog/$blogEntry.md";

    // Fetch the requested blog entry content from GitHub
    $blogContent = fetchGitHubContent($blogEntryPath);

    if ($blogContent !== false) {
        renderMarkdown(base64_decode($blogContent['content']));
    } else {
        // Show the 404.md from the 'pages' folder
        renderMarkdown(fetchGitHubContent("https://api.github.com/repos/$githubRepo/contents/pages/404.md")['content']);
    }
} else {
    // Check if the requested route is like /page-slug-here
    $requestedSlug = substr($requestedPath, 1); // Remove the leading '/'
    $pagePath = "https://api.github.com/repos/$githubRepo/contents/pages/$requestedSlug.md";

    // Fetch the requested page content from GitHub
    $pageContent = fetchGitHubContent($pagePath);

    if ($pageContent !== false) {
        renderMarkdown(base64_decode($pageContent['content']));
    } else {
        // Show the 404.md from the 'pages' folder
        renderMarkdown(fetchGitHubContent("https://api.github.com/repos/$githubRepo/contents/pages/404.md")['content']);
    }
}

// Function to fetch content from GitHub
function fetchGitHubContent($url)
{
    global $githubToken;
    $options = [
        'http' => [
            'header' => "Authorization: token $githubToken\r\n" . "User-Agent: Awesome-App"
        ]
    ];
    $context = stream_context_create($options);
    $content = @file_get_contents($url, false, $context);

    return $content ? json_decode($content, true) : false;
}