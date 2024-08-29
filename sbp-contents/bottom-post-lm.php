<div class="container mt-50" id="postContainer">
    <!-- Trending Bottom -->
    <div class="trending-bottom">
        <div class="section-title mb-30">
            <h3>All Posts</h3>
        </div>
        <div class="row" id="postList">
         <?php include 'load-more.php'; ?>
            <!-- Posts will be dynamically loaded here -->
        </div>
        <div class="row mb-30">
            <div class="col-lg-12 text-center">
                <button class="btn" id="loadMoreBtn">Load More</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

