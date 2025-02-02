<?php
// Function to create a unique filename
function createUniqueFilename($postTitle, $authorName) {
    $timestamp = date('YmdHis');
    $sanitizedTitle = preg_replace('/\s+/', '-', strtolower(trim($postTitle)));
    $sanitizedAuthor = preg_replace('/\s+/', '-', strtolower(trim($authorName)));
    return "{$sanitizedTitle}-{$sanitizedAuthor}-{$timestamp}.md";
}

// Function to validate user input
function getValidInput($prompt) {
    do {
        fwrite(STDOUT, $prompt);
        $input = trim(fgets(STDIN));
        if (!empty($input)) {
            return $input;
        }
        fwrite(STDOUT, "Input cannot be empty. Please try again.\n");
    } while (true);
}

// Request user input with validation
$postTitle = getValidInput("Enter the blog post title: ");
$authorName = getValidInput("Enter the author's name: ");
$categoryInput = getValidInput("Enter categories (comma-separated): ");
$categories = array_map('trim', explode(',', $categoryInput));

// Determine the directory for saving the file
$targetDir = !empty($argv[1]) ? rtrim($argv[1], DIRECTORY_SEPARATOR) : getcwd();

// Create the filename
$generatedFilename = createUniqueFilename($postTitle, $authorName);

// Generate markdown file content
$currentDate = date('Y-m-d');
$categoriesYaml = implode(", ", $categories); // Categories as comma-separated string
$markdownTemplate = "---\ntitle: \"{$postTitle}\"\nauthor: \"{$authorName}\"\ncategories: {$categoriesYaml}\ndate: \"{$currentDate}\"\n---\n\nWrite your blog post content here...";

// Write to file
$fileLocation = $targetDir . DIRECTORY_SEPARATOR . $generatedFilename;
file_put_contents($fileLocation, $markdownTemplate);

// Output result
fwrite(STDOUT, "Blog post template successfully created: {$fileLocation}\n");
?>