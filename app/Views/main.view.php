<?php

$logo = 'Iban Validator';

require_once './app/Views/layouts/app.view.php';

?>
<html lang="en">
<body class="body">
<div class="card text-center">
    <div class="card-header">
        <?php echo $logo; ?>
    </div>
    <div class="card-body text-left">
        <h5 class="card-title">Enter your IBAN</h5>
        <form action="/validate/" method="post">
            <div class="w-25 mb-5 input-group input-group-lg">
                <input name="iban" type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
            </div>
            <button class="btn btn-primary">Enter</button>
        </form>
    </div>
</div>
<?php if ($data['iban'] !== null && $data['country'] !== null) :?>
<h1><?php echo $data['iban']->getIbanNumber(); ?></h1>
<h1><?php echo $data['country']->getCountryName(); ?></h1>
<?php elseif ($data['violationMessage']) : ?>
<h1>
    <?php echo $data['violationMessage'] ; ?>
</h1>

<?php endif ; ?>
</body>
<footer>
</footer>
</html>