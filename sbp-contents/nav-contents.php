
<nav>
    <ul id="navigation">
        <li><a href="<?= $website ?>">Home</a></li>
        <?php
        include $doc_root . '/sbp-admin/credentials.php';
        // Fetch unique page titles from the database
        $sqlPage = "SELECT DISTINCT page_title, slug FROM sbp_pages WHERE displayInNav = 1";
        $resultPage = $conn->query($sqlPage);
        // Check if there are any pages
        if ($resultPage->num_rows > 0) {
            $pageTitles = array();
            $pageSlugs = array();
            // Fetching each page title and slug and storing them in arrays
            while ($row = $resultPage->fetch_assoc()) {
                $pageTitles[] = $row['page_title'];
                $pageSlugs[] = $row['slug'];
            }
            // Displaying page links
            for ($i = 0; $i < count($pageTitles); $i++) {
                echo '<li><a href="'. $website . '/' . $pageSlugs[$i] . '/">' . $pageTitles[$i] . '</a></li>';
            }
        } else {
            echo '';
        }
        ?>

        <li><a>Category</a>
            <ul class="submenu">
                <?php
                // Fetch unique categories from the database
                $sql = "SELECT DISTINCT post_category FROM sbp_posts";
                $result = $conn->query($sql);
                // Check if there are any categories
                if ($result->num_rows > 0) {
                    $categories = array();
                    // Fetching each category and storing them in an array
                    while ($row = $result->fetch_assoc()) {
                        $categories[] = $row['post_category'];
                    }
                    // Displaying category links
                    foreach ($categories as $category) {
                        echo '<li><a href="' . $website . '/category/' . $category . '/">' . $category . '</a></li>';
                    }
                } else {
                    echo '<li><a href="'. $website .'">Uncategorized</a></li>';
                }
                ?>
            </ul>
        </li>
    </ul>
</nav>
