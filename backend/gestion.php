<?php
require '../kernel/session_check.php';
require '../kernel/functions.php';
require '../kernel/db_connect.php';
require '../models/user.php';
$users = findAllUsers();
//var_dump($users);
//die();
require 'templates/header.php'
?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-right">
              <span class="badge badge-primary">Bienvenue <?= $_SESSION['login'] ?></span>
            </div>
            <div class="col-12">
                <h1>Gestion  des abonnés</h1>
                <?= getFlash() ?>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Admin ?</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($users as $user) :?>
                        <tr>
                            <td><?=$user['login']?></td>
                            <td><?=$user['email']?></td>
                            <td><?=strtoupper($user['nom']) ?></td>
                            <td><?=ucfirst($user['prenom'])?></td>
                            <td>
                                <?php if($user['is_admin']) :?>
                                <span class="badge badge-primary">admin</span>
                                <?php else :?>
                                <span class="badge badge-dark">user</span>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php $date_creation = date_create($user['created_at']) ?>
                                <?= date_format($date_creation,'d/m/Y H:i') ?>
<!--                                12/02/2019 14h59-->
                            </td>
                            <td><?php if(!$user['is_admin']) :?>
                                <a class="btn btn-outline-dark" href="../controllers/toggleAdmin.php?id=<?= $user['id'] ?>&admin=1">
                                    Donner droit admin</a>
                                    <?php else: ?>

                                <a class="btn btn-dark <?php if($_SESSION['id_admin'] == $user['id']) :?>disabled <?php endif ?>" href="../controllers/toggleAdmin.php?id=<?= $user['id'] ?>" >revoquer droit admin</a>
                                <?php endif ?>
                            </td>
                            </tr>
                    <?php endforeach ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="container text-center">
        <a onclick="return confirm('êtes-vous sûr(e) de nous quitter ?')"
        href="../controllers/logout.php">Quitter</a>

    </div>
<?php  require 'templates/footer.php' ?>
</body>
</html>