<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Удалить товар №<?= $id; ?></h2>


    <p>Вы действительно хотите удалить этот товар?</p>

    <form method="post">
        <input type="submit" name="submit" value="Удалить"/>
    </form>

</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
