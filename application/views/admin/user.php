<div class="row text-center">
    <a class="btn btn-success float-right" href="<?= base_url() ?>index.php/admin/adduser">Add New Users</a>
</div>
<div class="row mt-2">
    <h2>User list</h2>
    <div class="col-12">
        <div class="table">
            <table class="table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($user) {
                        foreach ($user as $val) { ?>
                            <tr>
                                <td><?= $val->US_FirstName ?></td>
                                <td><?= $val->US_LastName ?></td>
                                <td><?= $val->US_Email ?></td>
                                <td><?= $val->US_Phone ?></td>
                                <td><?= $val->US_Country ?></td>
                                <td><a class="edit" href="<?= base_url() ?>index.php/admin/edituser/<?= $val->US_Id ?>">Edit</a>&nbsp;&nbsp;<a class="delete" href="<?= base_url() ?>index.php/admin/deleteuser/<?= $val->US_Id ?>">Delete</a></td>
                            </tr>
                    <?php }
                    }else{
                        echo "<tr class='text-center'>No Data</tr>";
                    } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>