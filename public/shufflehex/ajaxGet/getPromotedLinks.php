<?php
include_once '../db.php';
$latestSql = "select * from `links` WHERE `promoted`='1' ORDER BY `posted` DESC";
$latestRes = $conn->query($latestSql);
while ($latestRow = $latestRes->fetch_assoc()) {
    ?>
    <div class="link-item">
        <div class="link-thumb">
            <img class="img-responsive"
                 src="http://www.mnra.gov.bz/wp-content/plugins/special-recent-posts/images/no-thumb.png">
        </div>
        <div class="link-content">
            <h4 class="link-title"><a class="text-primary"
                                      href="view.php?id=<?= $latestRow['id'] ?>&title=<?= str_replace(" ", "-", $latestRow['title']) ?>"
                                      target="_blank"><?= $latestRow['title'] ?></a></h4>
            <p class="link-desc"><?= $latestRow['desc'] ?></p>
            <p>Posted <strong><?= $latestRow['posted'] ?></strong></p>
        </div>
    </div>
    <?php
}
?>