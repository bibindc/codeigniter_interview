<div class="row">

    <a class="float-right btn btn-warning" href="<?= base_url() ?>index.php/customer">Back</a>
    <?php
    $storyId = 0;
    $comments = array();
    $story = array();
    foreach ($stories as $data) {
        if ($data->ST_Type == 1) {
            $storyId = $data->ST_Id;
            $story = $data;
        } else
            $comments[$data->ST_ParantId][] = $data;
    }

    ?>
    <h3 class="text-success"><u>Story Details</u></h3>
    <h4><B>Title </B> :<?= $story->ST_Author ?></h4>
    <h5><B>Author</B> : <?= $story->ST_Author ?></h5>
    <h5><B>URL</B> : <?= $story->ST_Url ?></h5>
    <h5><B>Points</B> : <?= $story->ST_Points ?></h5>
    <p>Created On :<?= $story->ST_CDate ?></p>
    <div style="padding: 10px;">
        <?php if ($comments) {
            echo "<b class='text-primary'>Comments</b>";
            foreach ($comments[$storyId] as $com) { ?>
                <div style="padding-bottom:5px;border-bottom:1px solid #ccc;">
                    <h5><B>Author</B> : <?= $com->ST_Author ?></h5>
                    <h5><B>Comment</B> : <?= $com->ST_Text ?></h5>
                    <p>Posted On :<?= $com->ST_CDate ?></p>
                </div>
        <?php }
        } ?>
    </div>
</div>