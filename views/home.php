<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h1>Balance</h1>

    <table class="balance-table">
        <thead>Keep an eye on your money</thead>
        <tbody>
            <?php
            require_once APP_PATH . 'app.php';

            foreach ($fileContent as $i => $line) {
                if ($i === 0) {
                    echo '<tr>';
                    foreach ($line as $th) echo '<th>' . $th . '</th>';
                    echo '</tr>';
                    continue;
                }

                echo '<tr>';
                foreach ($line as $i => $tr) {
                  if ($i === (count($line) - 1)) {
                    $className = str_contains($tr, '-')? " class='neg'" : " class='pos'";

                    echo"<td${className}>" . $tr . '</td>';
                    continue;
                  }
                  echo '<td>' . $tr . '</td>';
                };
                echo '</tr>';
            }
            ?>
        </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total Income </td>
                    <td><?= $totalIncome ?></td>
                </tr>
                <tr>
                    <td colspan="3">Total Expense</td>
                    <td><?= $totalExpense ?></td>
                </tr>
                <tr>
                    <td colspan="3">Net Total</td>
                    <td><?= $netTotal ?></td>
                </tr>
            </tfoot>
    </table>
</body>

</html>
