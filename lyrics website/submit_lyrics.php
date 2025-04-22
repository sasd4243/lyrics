<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = htmlspecialchars($_POST['title']);
    $genre = htmlspecialchars($_POST['genre']);
    $lyrics = htmlspecialchars($_POST['lyrics']);

    // Generate a clean filename from the title
    $filename_base = strtolower(str_replace(" ", "_", $title));
    $html_filename = "lyrics/$filename_base.html";
    $txt_filename = "lyrics/$filename_base.txt";

    // Save lyrics as .txt for backup/log
    $txt_content = "Title: $title\nGenre: $genre\n\n$lyrics";
    file_put_contents($txt_filename, $txt_content);

    // Convert lyrics to <p> paragraphs for HTML
    $lyrics_html = '';
    foreach (explode("\n", $lyrics) as $line) {
        $lyrics_html .= "<p>" . htmlspecialchars($line) . "</p>\n";
    }

    // Create HTML content
    $html_content = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>$title - Khmer Lyrics</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
  <header>
    <h1>Khmer Lyrics</h1>
    <nav>
      <ul>
        <li><a href="../index.html">Home</a></li>
        <li><a href="../lyrics.html">All Lyrics</a></li>
        <li><a href="../submit.html">Submit</a></li>
        <li><a href="../contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="lyric-page">
      <h2>$title</h2>
      <p><strong>Genre:</strong> $genre</p>
      <div class="lyrics">
        $lyrics_html
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Khmer Lyrics. All rights reserved.</p>
  </footer>
</body>
</html>
HTML;

    // Save the generated HTML file
    file_put_contents($html_filename, $html_content);

    // Redirect to All Lyrics page (or directly to the new lyric)
    header("Location: lyrics.html");
    exit();
}
?>
