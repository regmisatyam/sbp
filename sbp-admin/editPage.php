<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edit Page | Satyam Blogs</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">

    <!-- CSS here -->
    <?php include '../sbp-contents/importCss.php'; ?>
</head>

<body>

    <header>
        <!-- Header Start -->
        <?php include '../sbp-contents/top-header.php'; ?>
        <!-- Header End -->
    </header>

    <main>
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);

        include '../sbp-contents/globalVar.php';
        include 'credentials.php'; // Include database credentials file

        // Update logic
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $id = $_POST['id'];
            $page_title = $_POST['title'];
            $page_contents = $_POST['contents'];
            $slug = $_POST['slug'];
            $author = $_POST['author'];
            $date = $_POST['date'];

            // Update page fields in the database using prepared statements
            $update_sql = "UPDATE sbp_pages SET page_title=?, page_contents=?, slug=?, author=?, date=? WHERE id=?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("sssssi", $page_title, $page_contents, $slug, $author, $date, $id);

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "Page updated successfully";
                $stmt->close();
            } else {
                echo "Error updating page: " . $stmt->error;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = $_GET['id'];

            // Query to retrieve page details based on ID
            $sql = "SELECT page_title, page_contents, slug, author, date FROM sbp_pages WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Display the form to edit page details
                ?>
                <head>
                     <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/skins/ui/oxide/skin.min.css">
                        <!-- Include CodeMirror CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.css">
     <!-- Include CodeMirror JavaScript -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.js"></script>
     <!-- Include the language mode (optional) -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/mode/javascript/javascript.min.js"></script>
     <!-- Include a dark theme (for example, material-darker) -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/theme/material-darker.min.css">
 
                    <style>
                        form { max-width: 1200px; margin: 0 auto; padding: 20px; }
                        input[type="text"], textarea { width: 100%; padding: 10px; margin: 5px; }
                        input[type="submit"] { background-color: #4e73df; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-top:10px; border-radius:7px;}
                        input[type="submit"]:hover { background-color: #4e73dfab;}
                        input[type="text"]:focus-visible { outline: 0px;}
                        .CodeMirror {height: 500px;z-index:1;}
                    </style>
                </head>
                <body>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label for="title">Title:</label><br>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($row["page_title"]); ?>"><br>
                        <label for="contents">Contents:</label><br>
                        <textarea name="contents" id="editor"><?php echo htmlspecialchars($row["page_contents"]); ?></textarea><br>
                        <label for="slug">Slug:</label><br>
                        <input type="text" name="slug" value="<?php echo htmlspecialchars($row["slug"]); ?>"><br>
                        <label for="author">Author:</label><br>
                        <input type="text" name="author" value="<?php echo htmlspecialchars($row["author"]); ?>"><br>
                        <label for="date">Date:</label><br>
                        <input type="text" name="date" value="<?php echo htmlspecialchars($row["date"]); ?>"><br>
                        <input type="submit" value="Save Changes">
                    </form>
                    <script src="https://cdn.tiny.cloud/1/0kl5l33c89bex4zk7r65pvotwt9rf7zm1zghsqx8ejlgract/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
                    <!--   <script>
                        tinymce.init({
                            selector: "textarea",
                            plugins: "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker",
                            toolbar: "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat",
                            tinycomments_mode: "embedded",
                            tinycomments_author: "Author name",
                            mergetags_list: [
                                { value: "First.Name", title: "First Name" },
                                { value: "Email", title: "Email" },
                            ],
                        });
                    </script>
                    <!-- Initialize CodeMirror -->
<script>
    // Initialize CodeMirror
    var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
        lineNumbers: true, // Enable line numbers
        mode: "javascript", // Set mode (language)
        theme: "material-darker" // Set theme (optional)
    });
</script>
                </body>
        <?php
            } else {
                echo 'Page not found';
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            echo 'Invalid request';
        }
        ?>
    </main>

    <footer>
        <?php include_once '../sbp-contents/footer.php'; ?>
    </footer>

    <!-- JS here -->
    <?php include '../sbp-contents/importJs.php'; ?>
</body>

</html>
