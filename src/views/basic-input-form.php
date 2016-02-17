<html>
<head>

</head>
<body>
<?php if ($message) {?>
    <div class="message"><?php echo $message; ?></div>
<?php }?>
<form method="post">
    <table>
        <tr>
            <th>First name</th>
            <th>Last name</th>
        </tr>
        <?php for ($i = 0; $i < count($people); $i++) { ?>
        <tr>
            <td>
                <input type="text" name="people[<?php echo $i?>][firstname]" value="<?php echo $people[$i]->getFirstName(); ?>" />
            </td>
            <td>
                <input type="text" name="people[<?php echo $i?>][surname]" value="<?php echo $people[$i]->getSurname(); ?>" />
            </td>
        </tr>
        <?php } ?>
    </table>
    <input type="submit" value="OK" />
</form>
</body>
</html>