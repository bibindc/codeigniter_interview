<div class="row mt-2">
    <h2>User list</h2>
    <div class="col-12">
        <div class="table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Content Type</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Url</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($stories) {
                        $sub = array(
                            1 => 'Story',
                            2 => 'Comment',
                            3 => 'Poll'
                        );
                        foreach ($stories as $val) {
                            if ($val->ST_Type == 1)
                                $id = $val->ST_Id;
                            else
                                $id = $val->ST_StoryId;
                    ?>
                            <tr>
                                <td><?= $sub[$val->ST_Type] ?></td>
                                <td><?= $val->ST_Author ?></td>
                                <td><?= $val->ST_Title ? $val->ST_Title : '-' ?></td>
                                <td><?= $val->ST_Url ? $val->ST_Url : '-' ?></td>
                                <td><a class="edit" href="<?= base_url() ?>index.php/customer/viewdata/<?= $id ?>">View</a>&nbsp;&nbsp;</td>
                            </tr>
                    <?php }
                    } else {
                        echo '<tr class="text-center">No Data</tr>';
                    } ?>

                </tbody>
            </table>
        </div>
        <div id="pagination">
            <ul class="pagination_sub">
                <!-- Show pagination links -->
                <?php foreach ($links as $link) {
                    echo "<li>" . $link . "</li>";
                } ?>
            </ul>
        </div>
    </div>
</div>