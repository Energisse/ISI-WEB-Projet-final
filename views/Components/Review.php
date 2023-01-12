<?php

function Review(Review $review)
{
?>
    <div class="review">
        <img src="/assets/images/users/<?= $review->getUser()->getImage() ?>" class="user-image" />
        <?= $review->getUser()->getUsername() ?>
        <h1><?= $review->getTitle() ?>
            <?php
            $note = $review->getStars();
            for ($etoile = 0; $etoile < 5; $etoile++) {
                if ($note >= 1) {
                    echo '<i class="fa-solid fa-star active"></i>';
                } else {
                    echo '<i class="fa-solid fa-star "></i>';
                }
                $note--;
            }
            ?>
        </h1>
        <p><?= $review->getDescription() ?></p>
        <p class="review-date">Le <?= date_format($review->getDate(), 'Y-m-d H:i:s') ?></p>
    </div>
<?php
}
