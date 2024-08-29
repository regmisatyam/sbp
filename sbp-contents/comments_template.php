<style>
    .link {
        color: #fc3f00
    }

    .link:hover {
        color: #dc3545
    }
</style>
<section class="gradient-custom">
    <div class="container my-5 py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-10 col-xl-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4 pb-2"> Comments</h4>

                        <div class="row">
                            <div class="col">
                                <?php
                                error_reporting(E_ALL);
                                ini_set('display_errors', 1);
                                $post_slug = $_GET['slug'];
                                // Fetch comments from the database
                                $sql_cmnt = "SELECT * FROM sbp_comments WHERE post_slug = ? AND is_posted = 0";
                                $stmt_cmnt = $conn->prepare($sql_cmnt);
                                $stmt_cmnt->bind_param("s", $post_slug);
                                $stmt_cmnt->execute();
                                $result_cmnt = $stmt_cmnt->get_result();

                                // Check if there are any comments
                                if ($result_cmnt->num_rows > 0) {
                                    // Comments are available, display them
                                    while ($row_cmnt = $result_cmnt->fetch_assoc()) {
                                        ?>
                                        <div class="d-flex flex-start mt-4">
                                            <img class="rounded-circle shadow-1-strong mr-3"
                                                src="https://cdn-icons-png.flaticon.com/512/9187/9187604.png" alt="avatar"
                                                width="45" height="45" />
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1">
                                                            <?php echo $row_cmnt['name']; ?> <span class="small">-
                                                                <?php echo $row_cmnt['comment_date']; ?></span>
                                                        </p>
                                                        <a href="#!" class="link reply-link"><i
                                                                class="fas fa-reply fa-xs"></i><span class="small">
                                                                reply</span></a>
                                                    </div>
                                                    <p class="small mb-0">
                                                        <?php echo $row_cmnt['comment']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!--
                                          <div class="d-flex flex-start mt-4">
                                            <a class="mr-3" href="#">
                                                <img class="rounded-circle shadow-1-strong" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(11).webp" alt="avatar" width="45" height="45" />
                                            </a>
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1">
                                                            Simona Disa <span class="small">- 3 hours ago</span>
                                                        </p>
                                                        <a href="#!" class="link"><i class="fas fa-reply fa-xs"></i><span class="small"> reply</span></a>
                                                    </div>
                                                    <p class="small mb-0">
                                                        letters, as opposed to using 'Content here, content here',
                                                        making it look like readable English.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                        <?php
                                    }
                                } else {
                                    // No comments available
                                    echo '<span>No comments yet!</span>';
                                }
                                // Close the database connection
                                // $conn->close();
                                ?>

                                <!-- <span>No comments yet!</span>
                                <div class="d-flex flex-start">
                                    <img class="rounded-circle shadow-1-strong mr-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(10).webp" alt="avatar" width="45" height="45" />
                                    <div class="flex-grow-1 flex-shrink-1">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-1">
                                                    Maria Smantha <span class="small">- 2 hours ago</span>
                                                </p>
                                                <a href="#!" class="link"><i class="fas fa-reply fa-xs"></i><span class="small"> reply</span></a>
                                            </div>
                                            <p class="small mb-0">
                                                It is a long established fact that a reader will be distracted by
                                                the readable content of a page.
                                            </p>
                                        </div>

                                        <div class="d-flex flex-start mt-4">
                                            <a class="mr-3" href="#">
                                                <img class="rounded-circle shadow-1-strong" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(11).webp" alt="avatar" width="45" height="45" />
                                            </a>
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1">
                                                            Simona Disa <span class="small">- 3 hours ago</span>
                                                        </p>
                                                        <a href="#!" class="link"><i class="fas fa-reply fa-xs"></i><span class="small"> reply</span></a>
                                                    </div>
                                                    <p class="small mb-0">
                                                        letters, as opposed to using 'Content here, content here',
                                                        making it look like readable English.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-start mt-4">
                                            <a class="mr-3" href="#">
                                                <img class="rounded-circle shadow-1-strong" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp" alt="avatar" width="45" height="45" />
                                            </a>
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1">
                                                            John Smith <span class="small">- 4 hours ago</span>
                                                        </p>
                                                        <a href="#!" class="link"><i class="fas fa-reply fa-xs"></i><span class="small"> reply</span></a>
                                                    </div>
                                                    <p class="small mb-0">
                                                        the majority have suffered alteration in some form, by
                                                        injected humour, or randomised words.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>